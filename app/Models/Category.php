<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['nm_kategori'];
    public $timestamps = false;
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
}
