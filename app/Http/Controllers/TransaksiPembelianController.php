<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Pembelian;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class TransaksiPembelianController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.transaksi.pembelian.index', [
            'purcahses' => Pembelian::with(['user', 'supplier', 'detail_pembelian' => function ($query) {
                $query->join('products', 'products.id_product', '=', 'detail_pembelians.id_product');
            }])->get(),
        ]);
    }

    public function create()
    {
        return view('admin.dashboard.transaksi.pembelian.create', [
            'title' => 'Tambah Pembelian',
            'products' => Product::all(),
            'suppliers' => Supplier::all(),
            'details' => DetailPembelian::with(['product', 'pembelian'])->where('status', 1)->get(),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        function generateRandomString($length = 10)
        {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        $oi = generateRandomString(10);
        //
        $validateData = $request->validate([
            'id_pembelian' => '',
            'id_product' => 'required',
            'harga' => 'required',
            'jumlah' => 'required',
        ]);
        $validateData['harga'] = str_replace(".", "", $request->harga);
        $validateData['id_detail_pembelian'] = $oi;
        $validateData['status'] = 1;
        $cek = DetailPembelian::where('id_product', $request->id_product)->where('harga', $validateData['harga'])
            ->where('status', 1)->first();
        $cekHargaBeda = DetailPembelian::where('id_product', $request->id_product)->where('harga', '!=', $validateData['harga'])->where('status', 1)->first();
        // dd($cekHargaBeda);
        if ($cekHargaBeda) {
            $request->session()->flash('status_text', '');
            return redirect('/transaksi-pembelian/create')->with('status_icon', 'error')
                ->with('status', 'Gagal! Harga tidak boleh berbeda!');
        } else {
            if ($cek) {
                DetailPembelian::where('id_product', $request->id_product)
                    ->update([
                        'jumlah' => $request->jumlah + $cek->jumlah,
                    ]);
                return redirect('/transaksi-pembelian/create')->with('status_icon', 'success')
                    ->with('status', 'Jumlah Berhasil Ditambah!');
            } else {
                DetailPembelian::create($validateData);
                $request->session()->flash('status_text', '');
                return redirect('/transaksi-pembelian/create')->with('status_icon', 'success')
                    ->with('status', 'Berhasil Menambah Pembelian!');
            }
        }
    }

    public function cekFaktur(Request $request)
    {
        $cekFaktur = Pembelian::where('no_faktur', $request->no_faktur)->first();
        if ($cekFaktur) {
            echo json_encode([
                'hasil' => 1
            ]);
        } else {
            echo json_encode([
                'hasil' => 0
            ]);
        }
    }
    public function store_pembelian(Request $request)
    {
        $details = DetailPembelian::where('status', 1)->get();
        if (!$details->isEmpty()) {
            Pembelian::create([
                'id_supplier' => $request->id_supplier,
                'id_user' => auth()->user()->id,
                'no_faktur' => $request->no_faktur,
                'tanggal' => $request->tanggal,
            ]);
            foreach ($details as $detail) {
                $products = Product::where('id_product', $detail->id_product)->get();
                foreach ($products as $product) {
                    Product::where('id_product', $detail->id_product)
                        ->update([
                            'jumlah' => $product->jumlah + $detail->jumlah
                        ]);
                }
            }
            $ambilID = Pembelian::latest('id_supplier')->first();
            DetailPembelian::where('status', 1)->where('id_pembelian', NULL)
                ->update([
                    'status' => 2,
                    'id_pembelian' => $ambilID->id_pembelian,
                ]);
            return redirect('/transaksi-pembelian')->with('status_icon', 'success')
                ->with('status', 'Simpan Pembelian Berhasil!');
        } else {
            return redirect('/transaksi-pembelian/create')->with('status_icon', 'error')
                ->with('status', 'Table Masih Kosong!');
        }
    }

    public function show(Pembelian $id_pembelian)
    {
        return view('admin.dashboard.transaksi.pembelian.detail', [
            'details' => DetailPembelian::with('product')->where('id_pembelian', $id_pembelian->id_pembelian)->get(),
            'title' => 'Detail Pembelian',
        ]);
    }
    public function destroy(DetailPembelian $id_detail_pembelian)
    {
        // dd($detailPembelian);
        DetailPembelian::destroy($id_detail_pembelian->id_detail_pembelian);
        session()->flash('status_text', '');
        return redirect('/transaksi-pembelian/create')->with('status_icon', 'success')
            ->with('status', 'Pembelian Berhasil Dihapus!');
    }
}
