<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerCategoryController extends Controller
{
    public function index($nama_kategori)
    {
        // dd($nama_kategori);
        return view('ui_user.dashboard.product', [
            'products' => Product::with('category')->join('categories', 'categories.id', '=', 'products.id_kategori')
                ->where('jumlah', '>=', 1)
                ->where('nama_kategori', $nama_kategori)
                ->paginate(6)->withQueryString(),
            'count' => Product::where('jumlah', '>=', 1)->count(),
            'categories' => Category::all(),
        ]);
    }
}
