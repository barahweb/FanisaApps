<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailOrder;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Veritrans\Midtrans;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;
// use App\Veritrans\Midtrans;
use Exception;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public $id_provinsi, $id_kota, $jasa, $daftarProvinsi, $daftarKota;
    // public function __construct()
    // {
    //     Midtrans::$serverKey = 'SB-Mid-server-anmvZEBK3Sy9ni8wH6enXDip';
    //     Midtrans::$isProduction = false;
    //     updateBatal();
    // }

    public function token(Request $request)
    {
        // error_log('masuk ke snap token adri ajax');
        $midtrans = new Midtrans;
        $id_order = $request->id_order;
        $nama_user = session('user');
        $hargaOngkir = $request->hargaOngkir;
        $nohp = $request->nohp;
        $barangs = DetailOrder::join('menu', 'menu.kd_menu', '=', 'detail_orders.kd_menu')
            ->where('status', 1)->where('id_customer', session('id_user'))->get();
        // Populate items
        $items = [];
        $total = 0;
        foreach ($barangs as $barang => $value) {
            $total += $value['harga'] * $value['quantity'];
            $items[] = [
                "id" => $value['kd_menu'],
                "price" => (float)$value['harga'],
                "quantity" => (int)$value['quantity'],
                "name" => $value['nama_barang']
            ];
        }
        $items[] = [
            "id" => 'ONG',
            "price" => (float)$hargaOngkir,
            "quantity" => 1,
            "name" => "Ongkos Kirim"
        ];
        $total += (float)$hargaOngkir;
        $transaction_details = array(
            'order_id'          => $id_order,
            'gross_amount'  => $total
        );
        $billing_address = array(
            'first_name'    =>  $nama_user,
            'phone'         => $nohp,
            'country_code'  => 'IDN'
        );
        // Populate customer's shipping address
        $shipping_address = array(
            'first_name'    =>  $nama_user,
            'phone'         => $nohp,
            'country_code'  => 'IDN'
        );
        // Populate customer's Info
        $customer_details = array(
            'first_name'    => $nama_user,
            // 'email'         => $_SESSION['email'],
            'phone'         => $nohp,
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );
        // Data yang akan dikirim untuk request redirect_url.
        // $enable_payments = array('credit_card', 'cimb_clicks', 'mandiri_clickpay', 'echannel');
        $transaction_data = array(
            // 'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'item_details'           => $items,
            'customer_details'   => $customer_details
        );

        $snap_token = $midtrans->getSnapToken($transaction_data);
        //return redirect($vtweb_url);
        echo $snap_token;
        // try {
        // } catch (Exception $e) {
        //     return $e->getMessage;
        // }
    }
    public function finish(Request $request)
    {
        // $result = $request->input('result_data');
        // $result = json_decode($result, true);
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
        $result = $request->input('result_data');
        $result = json_decode($result, true);
        $id_order = $result['order_id'];
        $pdf = $result['pdf_url'];
        $paketLayanan = $request->paketLayanan;
        $hargaOngkir = $request->hargaOngkir;
        $alamat = $request->alamat;
        $kurir = $request->kurir;
        $nama_kota = $request->nama_kota;
        $nama_provinsi = $request->nama_provinsi;
        $kodepos = $request->kodepos;
        $nohp = $request->nohp;
        // Cari barang yang akan dikurangi
        $barangs = DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
            ->join('products', 'products.kd_menu', '=', 'detail_orders.kd_menu')
            ->where('status', 1)->where('id_customer', session('id_user'))
            ->where('detail_orders.id_order', $id_order)->get();
        foreach ($barangs as $barang) {
            $ambilStok = Product::where('kd_menu', $barang->kd_menu)->get();

            // UPDATE STOK
            foreach ($ambilStok as $stok) {
                $cekPengurangan = $stok->jumlah - $barang->quantity;
                if ($cekPengurangan < 0) {
                    Cart::where('id_order', $id_order)
                        ->update([
                            'id_order' => $oi,
                        ]);
                    // DetailOrder::where('id_order', $id_order)
                    //     ->update([
                    //         'id_order' => $oi,
                    //     ]);
                    return redirect('/cart')->with('status_icon', 'error')
                        ->with('status', 'Terdapat jumlah barang yang melebihi stok!');
                }
                Product::where('kd_menu', $barang->kd_menu)
                    ->update([
                        'jumlah' => $stok->jumlah - $barang->quantity,
                    ]);
            }
        }
        Cart::where('id_order', $id_order)
            ->update([
                'status' => 2,
                'pdf' => $pdf,
                'ongkir' => $hargaOngkir,
                'ekspedisi' => strtoupper($kurir)  . ' - ' . $paketLayanan,
            ]);
        // ShippingAddress::create([
        //     'id_order' => $id_order,
        //     'provinsi' => $nama_provinsi,
        //     'kabupaten' => $nama_kota,
        //     'kode_pos' => $kodepos,
        //     'alamat' => $alamat
        // ]);
        return redirect('/transaction-history')->with('status_icon', 'success')
            ->with('status', 'Berhasil Memesan Barang!');
    }
    public function index()
    {
        // dd($carts);
        return view('ui_user.cart.index', [
            'carts' =>  DetailOrder::with(['order', 'product'])
            ->whereHas('order', function ($query) {
                $query->where('status', 1);
                $query->where('id_cus', session('id_user'));
            })->get(),
        ]);
    }

    public function sudahBayar()
    {
        $result = json_decode(file_get_contents('php://input'), true);
        $invoice = $result['order_id'];
        $transaction_id = $result['transaction_id'];
        $status_code = $result['status_code'];
        if ($status_code == '200') {
            Cart::where('id_order', $invoice)->update([
                'status' => 3,
            ]);
        }
    }

    public function finishOrder(Request $request)
    {
        // dd($request);
        $id_order = $request->id_order;
        Cart::where('id_order', $id_order)
            ->update([
                'status' => 5,
            ]);
        return redirect('/transaction-history')->with('status_icon', 'success')
            ->with('status', 'Berhasil Konfirmasi!');
    }
    public function transaction_history()
    {
        // return view('ui_user.cart.history', [
        //     'histories' =>  Cart::with(['order' => function ($query) {
        //         $query->join('products', 'products.kd_menu', '=', 'detail_orders.kd_menu');
        //     }])->where('status', '>', 1)->where('id_customer', session('id_user'))->latest()->paginate(10),
        // ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id_order)
    {
        // return DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')->where('id_customer', session('id_user'))->where('detail_orders.id_order', $id_order)->get();
        return view('ui_user.cart.detail_history', [
            'details' => DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')->where('id_customer', session('id_user'))->where('detail_orders.id_order', $id_order)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }


    public function updateCart(Request $request)
    {
        $kd_menu  = $request->input('product_id');
        $quantity = $request->input('quantity');
        // return response()->json(['quantity' => $quantity]);
        if ($request->session()->exists('user')) {
            $cekorder = Cart::where('id_customer', $request->session()->get('id_user'))->where('status', 1)->first();
            $data_barang = Product::select(['jumlah', 'harga', 'nama_barang'])->where('id_product', $id_product)->first();
            if ($cekorder) {
                $detail = DetailOrder::where('id_product', $id_product)->where('id_order', $cekorder['id_order'])->first();
                if ($detail) {
                    if ($quantity > $data_barang['jumlah']) {
                        DetailOrder::where('id_order', $detail['id_order'])
                        ->where('id_product', $id_product)
                        ->update(['quantity' => $quantity]);
                        return response()->json([
                            'hasil' => 0,
                            'jumlah' => $data_barang['jumlah'],
                            'namaBarang' => $data_barang['nama_barang'],
                            'harga' => $quantity * $data_barang['harga']
                        ]);
                    } else {
                        DetailOrder::where('id_order', $detail['id_order'])
                            ->where('id_product', $id_product)
                            ->update(['quantity' => $quantity]);
                        return response()->json([
                            'hasil' => 1,
                            'harga' => $quantity * $data_barang['harga']
                        ]);
                    }
                }
            }
        }
    }
    public function checkStokCart(Request $request)
    {
        $id_product  = $request->input('product_id');
        $data_barang = Product::select('jumlah')->where('id_product', $id_product)->first();
        return response()->json(['data_barang' => $data_barang->jumlah]);
    }

    public function get_province()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 7f6d47d43191502c6ece335f9992b049"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //ini kita decode data nya terlebih dahulu
            $response = json_decode($response, true);
            //ini untuk mengambil data provinsi yang ada di dalam rajaongkir result
            $data_pengirim = $response['rajaongkir']['results'];
            return $data_pengirim;
        }
    }


    public function get_ongkir($origin, $destination, $weight, $courier)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 7f6d47d43191502c6ece335f9992b049"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_ongkir = $response['rajaongkir']['results'];
            return json_encode($data_ongkir);
        }
    }
    public function get_city($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 7f6d47d43191502c6ece335f9992b049"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_kota = $response['rajaongkir']['results'];
            return json_encode($data_kota);
        }
    }
    public function checkout()
    {

        // CEK STOK
        $barangs = DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
            ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
            ->where('status', 1)->where('id_customer', session('id_user'))->get();
        if (!count($barangs)) {
            return redirect('/cart')->with('status_icon', 'error')
                ->with('status', 'Anda Belum Memiliki Barang Di Keranjang!');
        }
        foreach ($barangs as $barang) {
            $ambilStok = Product::where('id_product', $barang->id_product)->get();
            foreach ($ambilStok as $stok) {
                $cekPengurangan = $stok->jumlah - $barang->quantity;
                if ($cekPengurangan < 0) {
                    return redirect('/cart')->with('status_icon', 'error')
                        ->with('status', 'Terdapat jumlah barang yang melebihi stok!');
                }
            }
        }
        $provinsi = $this->get_province();
        return view('ui_user.cart.checkout', [
            'carts' =>  DetailOrder::with(['order', 'product'])->join('carts', 'carts.id_order', '=', 'detail_orders.id_order')->where('status', 1)->where('id_customer', session('id_user'))->get(),
            'id_order' =>  DetailOrder::with(['order', 'product'])->join('carts', 'carts.id_order', '=', 'detail_orders.id_order')->where('status', 1)->where('id_customer', session('id_user'))->first(),
            'daftarProvinsi' => $provinsi,
            'subHarga' => DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
                ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
                ->where('status', 1)->where('id_customer', session('id_user'))
                ->selectRaw('SUM(harga*quantity) as harga')->first(),
            'berat' => DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
                ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
                ->where('status', 1)->where('id_customer', session('id_user'))
                ->selectRaw('SUM(berat*quantity) as berat')->first(),
        ]);
    }
}
