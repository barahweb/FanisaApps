<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use Illuminate\Http\Request;

class LaporanPenjualanController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.laporan.laporan-penjualan', [
            'sales' => DetailOrder::with(['product'])
                ->join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
                ->where('status', 5)->whereDate('updated_at', '=', date('Y-m-d'))->get(),
            'tanggalawal' => date('Y-m-d'),
            'tanggalakhir' => date('Y-m-d'),
            'totalPenjualan' => DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
                ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
                ->where('status',  5)
                ->whereDate('updated_at', '=', date('Y-m-d'))
                ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first(),
        ]);
    }
    public function search(Request $request)
    {
        if ($request->tanggalawal > $request->tanggalakhir) {
            return redirect('laporan-penjualan')->with('status_icon', 'error')
                ->with('status', 'Tanggal Tidak Sesuai!');
        } else {
            $tanggalawal = $request->tanggalawal;
            $tanggalakhir = $request->tanggalakhir;
            return view('admin.dashboard.laporan.laporan-penjualan', [
                'sales' => DetailOrder::with(['product'])
                    ->join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
                    ->whereBetween('updated_at', [$tanggalawal, $tanggalakhir])
                    ->where('status', 5)->get(),
                'tanggalawal' => $request->tanggalawal,
                'tanggalakhir' => $request->tanggalakhir,
                'totalPenjualan' => DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
                    ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
                    ->where('status', 5)
                    ->whereBetween('updated_at', [$tanggalawal . " 00:00:00", $tanggalakhir . " 23:59:59"])
                    ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first(),
            ]);
        }
    }
}
