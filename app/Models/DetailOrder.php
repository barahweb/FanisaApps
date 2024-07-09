<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;
    protected $table = 'detail_order';
    protected $fillable = ['kd_menu', 'id_order', 'sub_total', 'qty', 'catatan'];
    public $timestamps = false;
    public function order()
    {
        return $this->belongsTo(Cart::class, 'id_order', 'id_order');
    }
    
    public function product()
    {
        return $this->belongsTo(Menu::class, 'kd_menu', 'kd_menu');
    }
}
