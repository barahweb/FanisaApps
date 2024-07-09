<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailOrder;
use Illuminate\Http\Request;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.transaksi.penjualan.index', [
            'sales' => Cart::with(['order' => function ($query) {
                $query->join('products', 'products.id_product', '=', 'detail_orders.id_product');
            }, 'customer', 'shipping_address'])->where('status', 3)->get(),
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'nomor_resi' => 'required|unique:carts',
        ]);
        $updateCart = Cart::where('id_order', $request->idOrderUpd)
            ->update([
                'nomor_resi' => $request->nomor_resi,
                'status' => '4',
            ]);
        if ($updateCart) {
            $request->session()->flash('status_text', 'Successfull!');
            return redirect('transaksi-penjualan')->with('status_icon', 'success')
                ->with('status', 'Berhasil Update Resi!');
        } else {
            $request->session()->flash('status_text', 'Error!');
            return redirect('transaksi-penjualan')->with('status_icon', 'error')
                ->with('status', 'Resi Sudah Digunakan!');
        }
    }

    public function cekResi(Request $request){
        $cekResi = Cart::where('nomor_resi', $request->no_resi)->first();
        if($cekResi){
            echo json_encode([
                'hasil' => 1
            ]);
        } else {
            echo json_encode([
                'hasil' => 0
            ]);
        }
    }
}
