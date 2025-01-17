<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id_order', 'provinsi', 'kabupaten', 'kode_pos', 'alamat'];
}
