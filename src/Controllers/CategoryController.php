<?php

namespace JaopMX\FaqPackage\Controllers;

use Validator;
use JaopMX\FaqPackage\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{

    public function all()
    {
        if (session()->has('faq-role')) {
            $role = session()->get('faq-role');

            $categories = Category::whereHas('posts', function ($q) use ($role) {
                $q->where('roles', 'like', '%'.$role.'%');
            })->get();

        } else {
            $categories = Category::all();
        }

        return view()->first(['faq.categories-all', 'FaqPackage::categories-all'])->with('categories', $categories);
    }

    public function index()
    {
        $categories = Category::all();
        return view('FaqPackage::categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required|unique:faq_categories',
                'description' => 'required'],
            ['required' => 'El campo :attribute es requerido.', 'unique' => 'El nombre no puede estar repetido.']
        );

        if ($validator->fails()) {
            return redirect()->route('categories.index')->withErrors($validator);
        } else {
            $data = $request->all();
            $data['slug'] = Str::slug($data['name']);
            $category = Category::create($data);
            return redirect()->route('categories.index')->withSuccess('¡Categoría ' . $category->name . ' creada exitosamente!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $category_id = $request->get('category_id', 0);
        $data = [];
        if ($category_id) {
            $category = Category::find($request->get('category_id'));
            $data['name'] = $request->get('name');
            $data['description'] = $request->get('description');
            $data['slug'] = Str::slug($data['name']);
            $category->update($data);
            return redirect()->route('categories.index')->withSuccess('¡Categoría actualizada exitosamente!');
        } else {
            return redirect()->route('categories.index')->with('error', 'No se ha podido actualizar la categoría');
        }
    }

    public function show($slug)
    {
        $category = Category::with(['posts' => function ($query) {
            if(session()->has('faq-role')){
                $query->where('roles', 'like', '%'.session()->get('faq-role').'%');
            }
            $query->where('active', 1);
        }])->where('slug', $slug)->first();

        return view()->first(['faq.category-show', 'FaqPackage::category-show'])->with('category', $category);;
    }
}