<?php

namespace App\Console;

use App\Models\Cart;
use App\Models\DetailOrder;
use App\Models\Product;
use App\Models\ShippingAddress;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->call(function () {
    //         $carts = Cart::with(['order' => function ($query) {
    //             $query->join('products', 'products.id_product', '=', 'detail_orders.id_product');
    //         }])->where('status', 2)->get();
    //         foreach ($carts as $cart) {
    //             $tgl = $cart->updated_at;
    //             $pembatalan = date("Y-m-d H:i:s", strtotime("{$tgl} + 60 minute"));
    //             $sekarang = date("Y-m-d H:i:s");
    //             foreach ($cart->order as $order) {
    //                 if ($sekarang > $pembatalan) {
    //                     $barangs = DetailOrder::where('id_product', $order->id_product)->get('quantity');
    //                     $totalBarang = $barangs->sum('quantity') + $order->jumlah;
    //                     // Update Stok Barang
    //                     Product::where('id_product', $order->id_product)
    //                         ->update([
    //                             'jumlah' => $totalBarang
    //                         ]);

    //                     // Update Status Pemesanan
    //                     Cart::where('id_order', $order->id_order)
    //                         ->update([
    //                             'status' => '0',
    //                         ]);

    //                     // Hapus Shipping Address
    //                     ShippingAddress::where('id_order', $order->id_order)
    //                         ->delete();
    //                 }
    //             }
    //         }
    //         //Pengecekan apakah cronjob berhasil atau tidak
    //         //Mencatat info log 
    //         Log::info('Cronjob berhasil dijalankan');
    //     })->everyTwoMinutes();
    // }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
