<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = ['id_order', 'id_cus', 'tgl_pesanan', 'no_tlp', 'alamat', 'total', 'dp', 'status'];
    public $timestamps = false;
    public function order()
    {
        return $this->hasMany(DetailOrder::class, 'id_order', 'id_order');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_cus', 'id_cus');
    }
    public function shipping_address()
    {
        return $this->hasOne(ShippingAddress::class, 'id_order', 'id_order');
    }
}
