<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.master.category.index', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.master.category.create', [
            'title' => 'Tambah Kategori',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_kategori' => 'required|max:30|unique:categories',
        ]);
        Category::create($validateData);
        $request->session()->flash('status_text', '');
        return redirect('/master/category')->with('status_icon', 'success')
            ->with('status', 'Berhasil Menambah Kategori!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.dashboard.master.category.edit', [
            'category' => $category,
            'title' => 'Edit Kategori',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules = ([
            'nama_kategori' => 'required|max:30',
        ]);
        if ($request->nama_kategori != $category->nama_kategori) {
            $rules['nama_kategori'] = 'required|unique:categories';
        }
        $validateData = $request->validate($rules);
        Category::where('id', $category->id)
            ->update($validateData);
        $request->session()->flash('status_text', 'Successfull!');
        return redirect('/master/category')->with('status_icon', 'success')
            ->with('status', 'Berhasil Update Kategori!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            Category::destroy($category->id);
            session()->flash('status_text', '');
            return redirect('/master/category')->with('status_icon', 'success')
                ->with('status', 'Kategori Berhasil Dihapus!');
        } catch (Exception $e) {
            return redirect('/master/category')->with('status_icon', 'error')
                ->with('status', 'Kategori Sedang Digunakan!');
        }
    }
}
