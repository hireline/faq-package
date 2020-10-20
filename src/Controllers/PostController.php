<?php

namespace JaopMX\FaqPackage\Controllers;

use Algolia\AlgoliaSearch\SearchIndex;
use JaopMX\FaqPackage\Models\Post;
use JaopMX\FaqPackage\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $posts = $user->posts()->with('author')->get();
            return view('FaqPackage::index', compact('posts'));
        } else {
            return redirect()->back()->withErrors('You are not logged in!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        $post = new Post();
    
        $postForRole = $this->getAllowedRolesToCreatePosts($request);
    
        return view('FaqPackage::post-editor', compact('post', 'categories', 'postForRole'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $data = $request->all();
            $data['active'] = 1;
            if ($user) {
                $data['slug'] = Str::slug($data['title']);
                $post = $user->posts()->create($data);
                $post->categories()->attach($request->get('category'));
                return redirect()->route('dashboard')->withSuccess('¡Artículo creado exitosamente!');
            }
            return redirect()->route('dashboard')->with('error', 'Ha ocurrido un error al crear el artículo');
        } else {
            return redirect()->back()->withErrors('You are not logged in!');
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @param $post_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$post_id)
    {
        $post = Post::find($post_id);
        $categories = Category::all();
    
        $postForRole = $this->getAllowedRolesToCreatePosts($request);

        return view('FaqPackage::post-editor', compact('categories', 'post', 'postForRole'));
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_id)
    {
        $post = Post::find($post_id);
        $data = $request->all();
        if ($post) {
            $data['slug'] = Str::slug($data['title']);
            $post->update($data);
            $post->categories()->detach();
            $post->categories()->attach($data['category']);
            return redirect()->route('dashboard')->withSuccess('¡Artículo actualizado exitosamente!');
        } else {
            return redirect()->route('dashboard')->with('error', 'Post no encontrado');
        }
    }

    public function toggle(Request $request)
    {
        $post = Post::find($request->get('post_id'));
        if ($post) {
            $post->active = !$post->active;
            $post->update();
            return redirect()->route('dashboard')->with('success', '¡Post modificado exitosamente!');
        } else {
            return redirect()->route('dashboard')->with('error', 'Ha ocurrido un error al modificar el post');
        }
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view()->first(['faq.post-show', 'FaqPackage::post-show'])->with('post', $post);
    }

    public function search(Request $request)
    {
//        $query = $request->get('q', '');
//        $algolia_id = config('scout.algolia.id');
//        $algolia_search = config('scout.algolia.search');
//        $posts = Post::search($query);

        return view()->first(['faq.post-search', 'FaqPackage::post-search']);
    }

    public function searchPartial()
    {
        $faqRole = session()->has('faq-role') ? session()->get('faq-role') : null;

        $posts = Post::search(request('q'), function (SearchIndex $algolia, string $query, array $options) use ($faqRole) {
            if ($faqRole) {
                $options['filters'] = 'roles:' . $faqRole;
            }
            return $algolia->search($query, $options);
        })->get();

        $view = view()->first(['faq.post-search-results', 'FaqPackage::_search'], compact('posts'))->render();

        return ['src' => $view];
    }
    
    /**
     * @param Request $request
     * @return array
     */
    private function getAllowedRolesToCreatePosts(Request $request)
    {
        $postForRole = [];
        $user = $request->user();
    
        foreach($user->roles as $role) {
            if(config("faq.role_can_create_posts_for_role.$role->name")) {
                $postForRole = array_merge($postForRole, config("faq.role_can_create_posts_for_role.$role->name"));
            }
        };
        
        return array_unique($postForRole);
    }
}