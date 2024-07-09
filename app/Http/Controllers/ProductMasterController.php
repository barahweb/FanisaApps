<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.master.product.index', [
            'menu' => Menu::with('category')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.master.product.create', [
            'categories' => Category::all(),
            'title' => 'Tambah Barang',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function ambilGambar(Request $request)
    {
        $get = Menu::where('kd_menu', $request->id_product)->first();
        if($get){
            return response()->json([
                'hasil' => 1,
                'gambar' => $get,
            ]);
        }else{
            return response()->json([
                'hasil' => 0,
            ]);
        }
    }

    public function store(Request $request)
    {
        // dd($request->gambar);
        if(count($request->gambar) > 4){
            $request->session()->flash('status_text', '');
            return back()->withInput($request->all())->with('status_icon', 'error')
                ->with('status', 'Gambar Melebihi 4!');
        } else {
        $validateData = $request->validate([
            'id_kategori' => 'required',
            'nm_menu' => 'required|max:255',
            'gambar' => 'required',
            'harga' => 'required',
            'jumlah' => '',
        ]);
        $image = array();
        if($files = $request->file('gambar')){
            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name.'.'.$ext;
                $upload_path = 'post-images/';
                $image_url = $upload_path.$image_full_name;
                $file->move('storage/'.$upload_path, $image_full_name);
                $image[] = $image_url;
            }
            $validateData['gambar'] = implode('|', $image);
        }
        $validateData['harga'] = str_replace(".", "", $request->harga);
        $validateData['jumlah'] = 0;
        $save = Menu::create($validateData);
        if($save){
            $request->session()->flash('status_text', '');
            return redirect('/master/products')->with('status_icon', 'success')
                ->with('status', 'Berhasil Menambah Barang!');
        }else{
            $request->session()->flash('status_text', '');
            return redirect('/master/products')->with('status_icon', 'error')
                ->with('status', 'Gagal Menambah Barang!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $product)
    {
        return view('admin.dashboard.master.product.edit', [
            'product' => $product,
            'title' => 'Edit Barang',
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $product)
    {
        // dd($request->all());
        // dd($request->oldImage);
        $oldImages = explode('|', $request->oldImage);
        $dataGambarLama = Menu::where('kd_menu', $request->id_product)->first();
        $DBoldImages = explode('|', $dataGambarLama->gambar);
        $newImages = explode('|', $request->gambarBaru);
        // BATAS
        $rules = [
            'id_kategori' => 'required',
            'nm_menu' => 'required|max:255',
            'harga' => 'required',
        ];
        $validateData = $request->validate($rules);
        $image = array();
        if($files = $request->file('gambar')){
            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name.'.'.$ext;
                $upload_path = 'post-images/';
                $image_url = $upload_path.$image_full_name;
                $file->move('storage/'.$upload_path, $image_full_name);
                $image[] = $image_url;
            }
            // Sudah Fix Buat Old Image
            if ($request->oldImage) {
                $gambarLama = array_diff($DBoldImages,$oldImages);
                foreach($gambarLama as $v){
                    Storage::delete($v);
                }
            }
            // Ambil Data Yang Masih ada dan sama dari gambar lama,
            $gambarSamaBaru = array_intersect($DBoldImages,$newImages);
            // Penggabung
            $gabunganGambar = array_merge($gambarSamaBaru,$image);
            $validateData['gambar'] = implode('|', $gabunganGambar);
            $validateData['harga'] = str_replace(".", "", $request->harga);
            Menu::where('kd_menu', $product->kd_menu)
            ->update($validateData);
            $request->session()->flash('status_text', 'Successfull!');
            return redirect('/master/products')->with('status_icon', 'success')
            ->with('status', 'Berhasil Update Barang!');
        } elseif(!$request->oldImage) {
            $validateData['harga'] = str_replace(".", "", $request->harga);
            Menu::where('kd_menu', $product->kd_menu)
            ->update($validateData);
            $request->session()->flash('status_text', 'Successfull!');
            return redirect('/master/products')->with('status_icon', 'success')
            ->with('status', 'Berhasil Update Barang!');
        } else {
            $gambarSamaBaru = array_intersect($DBoldImages,$oldImages);
            // dd($gambarSamaBaru);
            $validateData['gambar'] = implode('|', $gambarSamaBaru);
            $validateData['harga'] = str_replace(".", "", $request->harga);
            Menu::where('kd_menu', $product->kd_menu)
            ->update($validateData);
            $request->session()->flash('status_text', 'Successfull!');
            return redirect('/master/products')->with('status_icon', 'success')
            ->with('status', 'Berhasil Update Barang!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $product)
    {
        try {
            if ($product->gambar) {
                Storage::delete($product->gambar);
            }
            Menu::where('id_product', $product->id_product)->delete();
            session()->flash('status_text', '');
            return redirect('/master/products')->with('status_icon', 'success')
                ->with('status', 'Barang Berhasil Dihapus!');
        } catch (Exception $e) {
            return redirect('/master/products')->with('status_icon', 'error')
                ->with('status', 'Barang Sedang Digunakan!');
        }
    }
}
