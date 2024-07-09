<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class LaporanPembelianController extends Controller
{
    public function index(){
        return view('admin.dashboard.laporan.laporan-pembelian',[
            'purchases' => DetailPembelian::with(['product','pembelian.supplier'])->where('status', 2)
            ->join('pembelians','pembelians.id_pembelian', '=', 'detail_pembelians.id_pembelian')
            ->whereDate('pembelians.tanggal', '=', date('Y-m-d'))
            ->get(),
            'tanggalawal' => date('Y-m-d'),
            'tanggalakhir' => date('Y-m-d'),
            'totalPembelian' => DetailPembelian::join('pembelians', 'pembelians.id_pembelian', '=', 'detail_pembelians.id_pembelian')
            ->join('products', 'products.id_product', '=', 'detail_pembelians.id_product')
            ->where('status', '=', 2)
            ->whereDate('pembelians.tanggal', '=', date('Y-m-d'))
            ->selectRaw('COALESCE(SUM(detail_pembelians.harga*detail_pembelians.jumlah),0) as pembelian')->first(),
        ]);
    }
    public function search(Request $request){
       if($request->tanggalawal > $request->tanggalakhir){
        return redirect('laporan-pembelian')->with('status_icon', 'error')
        ->with('status', 'Tanggal Tidak Sesuai!');
       } else {
        $tanggalawal = $request->tanggalawal;
        $tanggalakhir = $request->tanggalakhir;
            return view('admin.dashboard.laporan.laporan-pembelian',[
                'purchases' => DetailPembelian::with(['product','pembelian.supplier'])
                ->join('pembelians','pembelians.id_pembelian', '=', 'detail_pembelians.id_pembelian')
                ->where('status', 2)->whereBetween('tanggal',[$tanggalawal,$tanggalakhir])->get(),
                'tanggalawal' => $request->tanggalawal,
                'tanggalakhir' => $request->tanggalakhir,
                'totalPembelian' => DetailPembelian::join('pembelians', 'pembelians.id_pembelian', '=', 'detail_pembelians.id_pembelian')
                ->join('products', 'products.id_product', '=', 'detail_pembelians.id_product')
                ->where('status', '=', 2)
                ->whereBetween('tanggal',[$tanggalawal,$tanggalakhir])
                ->selectRaw('COALESCE(SUM(detail_pembelians.harga*detail_pembelians.jumlah),0) as pembelian')->first(),
            ]);
        }
    }
}
