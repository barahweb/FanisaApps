<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pembelian';

    protected $fillable = ['id_supplier', 'id_user','no_faktur','tanggal'];
    public $timestamps = false;
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user','id');
    }
    
    public function detail_pembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian', 'id_pembelian');
    }
}
