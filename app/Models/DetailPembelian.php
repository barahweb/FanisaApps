<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_detail_pembelian';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id_detail_pembelian', 'id_pembelian','id_product','harga','jumlah','status'];
    public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian','id_pembelian');
    }
}
