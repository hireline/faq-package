<?php

namespace JaopMX\FaqPackage\Controllers;

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
    public function create()
    {
        $categories = Category::all();
        $post = new Post();
        return view('FaqPackage::post-editor', compact('post', 'categories'));
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
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $post = Post::find($post_id);
        $categories = Category::all();

        return view('FaqPackage::post-editor', compact('categories', 'post'));
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

        return view()->first(['faq.post-search', 'FaqPackage::post-search'], compact('posts'))->render;
    }

    public function searchPartial()
    {
        $posts = Post::search(request('q'))->get();

        $roles = json_encode(array_map(function ($role) {
            return 'roles: ' . $role;
        }, explode(',', request('roles'))));

        $view = view()->first(['faq.post-search-results', 'FaqPackage::_search'], compact('posts'))->render();
        return ['src' => $view];
    }
}