<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "produk";
    protected $guarded = ['id'];
    public $timestamps = false;
}
