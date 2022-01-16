<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = "sub_category";
    protected $guarded = ['id'];
    public $timestamps = false;
}
