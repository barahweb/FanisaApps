<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['id_kategori', 'nm_menu', 'harga', 'gambar'];
    protected $table = 'menu';
    public $timestamps = false;
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('nm_menu', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function($query, $category){
            return $query->whereHas('category', function($query) use ($category){
                $query->where('nm_kategori', $category);
            });
        });
        // if ($filters['sort'] ?? false) {
        //    if($filters['sort'] == 'price'){
        //         $query->where('jumlah', '>=', 1)->orderBy('harga', 'ASC');
        //    } elseif($filters['sort'] == 'recent') {
        //         $query->where('jumlah', '>=', 1)->orderBy('id_product', 'DESC');
        //    }
        // }
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }


    public function getRouteKeyName()
    {
        return 'kd_menu';
    }
}
