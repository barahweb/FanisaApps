<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id_cus'];
    protected $table = 'customer';
    protected $primaryKey = 'id_cus';
    protected $fillable = ['username', 'pass','email', 'no_tlp' ];
    public $timestamps = false;
}
