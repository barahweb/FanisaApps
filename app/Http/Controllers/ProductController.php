<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\DetailOrder;
use App\Models\Menu;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request('search'));
        // with('category')->where('jumlah', '>=', 1)->paginate(6)
        return view('ui_user.dashboard.product', [
            'products' => Menu::with('category')->filter(request(['search','category','sort']))->paginate(6)->withQueryString(),
            // 'count' => Menu::where('jumlah', '>=', 1)->count(),
            'categories' => Category::all(),
        ]);
    }
    public function master_admin()
    {
        return view('dashboard.master.product', [
            'products' => Menu::get(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        if ($request->session()->exists('user')) {
            $cekorder = Cart::where('id_cus', $request->id_customer)->where('status', 1)->first();
            $data_barang = Menu::where('kd_menu', $request->id_product)->first();
            $i = $request->jumlah;
            if ($cekorder) {
                $detail = DetailOrder::where('kd_menu', $request->id_product)->where('id_order', $cekorder['id_order'])->first();
                if ($detail) {
                    $jumlah_lama = $detail['qty'];
                    $jumlah_baru = $jumlah_lama + $i;
                    // dd($jumlah_baru)
                    if ($jumlah_baru > $data_barang['jumlah']) {
                        return back()->with('status_icon', 'error')
                            ->with('status', 'Barang Sudah Ada Di Keranjang dan Melebihi Stok Yang Tersedia!');
                    } else {
                        $update_quantity = DetailOrder::where('id_order', $detail['id_order'])
                            ->where('kd_menu', $request->id_product)
                            ->update(['qty' => $jumlah_baru]);
                        if ($update_quantity) {
                            return back()->with('status_icon', 'success')
                                ->with('status', 'Jumlah Pembelian Telah Ditambah!');
                        } else {
                            return back()->with('status_icon', 'error')
                                ->with('status', 'Tidak Dapat Menambah Jumlah Pembelian!');
                        }
                    }
                } else {
                    // if ($i > $data_barang['jumlah']) {
                    //     return back()->with('status_icon', 'error')
                    //         ->with('status', 'Jumlah Melebihi Stok!');
                    // } else {
                        $tambah_pembelian = DetailOrder::create([
                            'id_order' => $cekorder['id_order'],
                            'kd_menu' => $request->id_product,
                            'qty' => $request->jumlah,
                            
                        ]);
                        if ($tambah_pembelian) {
                            return back()->with('status_icon', 'success')
                                ->with('status', 'Barang Telah Ditambahkan Ke Keranjang!');
                        } else {
                            return back()->with('status_icon', 'error')
                                ->with('status', 'Tidak Dapat Menambah Ke Keranjang!');
                        }
                    // }
                }
            } else {
                // if ($i > $data_barang['jumlah']) {
                //     return back()->with('status_icon', 'error')
                //         ->with('status', 'Jumlah Melebihi Stok!');
                // }
                function generateRandomString2($length = 10)
                {
                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }
                $oi = generateRandomString2(10);
                $buat_cart = Cart::create([
                    'id_order' => $oi,
                    'id_cus' => $request->id_customer,
                    'status' => '1',
                ]);
                if ($buat_cart) {
                    $buat_detail_baru = DetailOrder::create([
                        'id_order' => $oi,
                        'kd_menu' => $request->id_product,
                        'qty' => $request->jumlah,
                    ]);
                    if ($buat_detail_baru) {
                        return back()->with('status_icon', 'success')
                            ->with('status', 'Barang Telah Ditambahkan Ke Keranjang!');
                    } else {
                        return back()->with('status_icon', 'error')
                            ->with('status', 'Tidak Dapat Menambah Ke Keranjang!');
                    }
                } else {
                    return back()->with('status_icon', 'error')
                        ->with('status', 'Tidak Dapat Menambah Ke Keranjang!');
                }
            }
        } else {
            return redirect('customer-login');
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
        // return $product;
        return view('ui_user.dashboard.product-detail', [
            'product' => $product,
            'related' => Menu::with('category')->whereNotIn('kd_menu', [$product->kd_menu])->where('id_kategori', $product->id_kategori)->limit(4)->get(),
            // 'related' => Menu::with('category')->whereNotIn('id_kategori', ['id_kategori', $product->id_kategori])->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $product)
    {
       
   
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $product)
    {
        // return $product;
        $cari = Cart::where('status', 1)->where('id_customer', session('id_user'))->first();
        $id_order = $cari->id_order;
        DetailOrder::where('id_product', $product->id_product)->where('id_order', $id_order)->delete();
        session()->flash('status_text', '');
        return redirect('/cart')->with('status_icon', 'success')
            ->with('status', 'Barang Berhasil Dihapus!');
    }

    // public function sort($sort)
    // {
    //     if($sort == 'recent'){
    //         // return view('ui_user.dashboard.product', [
    //         //     'products' => Menu::with('category')->where('jumlah', '>=', 1)->orderBy('id_product', 'desc')->filter()->paginate(6)->withQueryString(),
    //         //     'count' => Menu::where('jumlah', '>=', 1)->count(),
    //         //     'categories' => Category::all(),
    //         // ]);
    //         // $returnHTML = view('ui_user.dashboard.product',[
    //         //     'products' => Menu::with('category')->where('jumlah', '>=', 1)->orderBy('id_product', 'desc')->filter()->paginate(6)->withQueryString(),
    //         //     'count' => Menu::where('jumlah', '>=', 1)->count(),
    //         //     'categories' => Category::all(),
    //         // ])->render();
    //         return response()->json(array('hasil' => true, ));
    //     } else {
    //         echo json_encode([
    //             'hasil' => 0,
    //             'text' => 'ini bukan recent',
    //         ]);
    //     }
    // }
}
