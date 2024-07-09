<?php


use App\Models\DetailOrder;
use App\Models\Menu;
use App\Models\ShippingAddress;

function keranjang()
{
    return DetailOrder::with(['order', 'product'])
    ->whereHas('order', function ($query) {
        $query->where('status', 1);
        $query->where('id_cus', session('id_user'));
    })->count();
}
// function pendapatanHariSatu()
// {
//     return DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
//         ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
//         ->where('status', '=', 5)
//         ->whereRaw('DATE(carts.updated_at) = CURDATE() - INTERVAL 1 DAY')
//         ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first();
// }
// function pendapatanHariDua()
// {
//     return DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
//         ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
//         ->where('status', '=', 5)
//         ->whereRaw('DATE(carts.updated_at) = CURDATE() - INTERVAL 2 DAY')
//         ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first();
// }
// function pendapatanHariTiga()
// {
//     return DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
//         ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
//         ->where('status', '=', 5)
//         ->whereRaw('DATE(carts.updated_at) = CURDATE() - INTERVAL 3 DAY')
//         ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first();
// }
// function pendapatanHariEmpat()
// {
//     return DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
//         ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
//         ->where('status', '=', 5)
//         ->whereRaw('DATE(carts.updated_at) = CURDATE() - INTERVAL 4 DAY')
//         ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first();
// }
// function pendapatanHariLima()
// {
//     return DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
//         ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
//         ->where('status', '=', 5)
//         ->whereRaw('DATE(carts.updated_at) = CURDATE() - INTERVAL 5 DAY')
//         ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first();
// }
// function pendapatanHariEnam()
// {
//     return DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
//         ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
//         ->where('status', '=', 5)
//         ->whereRaw('DATE(carts.updated_at) = CURDATE() - INTERVAL 6 DAY')
//         ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first();
// }
// function pendapatanHariTujuh()
// {
//     return DetailOrder::join('carts', 'carts.id_order', '=', 'detail_orders.id_order')
//         ->join('products', 'products.id_product', '=', 'detail_orders.id_product')
//         ->where('status', '=', 5)
//         ->whereRaw('DATE(carts.updated_at) = CURDATE() - INTERVAL 7 DAY')
//         ->selectRaw('COALESCE(SUM(harga*quantity),0) as pendapatan')->first();
// }

// function tgl_indo($tgl)
// {
//     $tanggal = substr($tgl, 8, 2);
//     $bulan = getBulan(substr($tgl, 5, 2));
//     $tahun = substr($tgl, 0, 4);
//     return $tanggal . ' ' . $bulan . ' ' . $tahun;
// }

// function getBulan($bln)
// {
//     switch ($bln) {
//         case 1:
//             return 'Januari';
//             break;
//         case 2:
//             return 'Februari';
//             break;
//         case 3:
//             return 'Maret';
//             break;
//         case 4:
//             return 'April';
//             break;
//         case 5:
//             return 'Mei';
//             break;
//         case 6:
//             return 'Juni';
//             break;
//         case 7:
//             return 'Juli';
//             break;
//         case 8:
//             return 'Agustus';
//             break;
//         case 9:
//             return 'September';
//             break;
//         case 10:
//             return 'Oktober';
//             break;
//         case 11:
//             return 'November';
//             break;
//         case 12:
//             return 'Desember';
//             break;
//     }
// }

// function updateBatal()
// {
//     $carts = Cart::with(['order' => function ($query) {
//         $query->join('products', 'products.id_product', '=', 'detail_orders.id_product');
//     }])->where('status', 2)->get();
//     foreach ($carts as $cart) {
//         $tgl = $cart->updated_at;
//         $pembatalan = date("Y-m-d H:i:s", strtotime("{$tgl} + 60 minute"));
//         $sekarang = date("Y-m-d H:i:s");
//         foreach ($cart->order as $order) {
//             if ($sekarang > $pembatalan) {
//                 $barangs = DetailOrder::where('id_product', $order->id_product)->get('quantity');
//                 $totalBarang = $barangs->sum('quantity') + $order->jumlah;
//                 // Update Stok Barang
//                 Product::where('id_product', $order->id_product)
//                     ->update([
//                         'jumlah' => $totalBarang
//                     ]);

//                 // Update Status Pemesanan
//                 Cart::where('id_order', $order->id_order)
//                     ->update([
//                         'status' => '6',
//                     ]);
//                 // Hapus Shipping Address
//                 ShippingAddress::where('id_order', $order->id_order)
//                     ->delete();
//             }
//         }
//     }
// }
