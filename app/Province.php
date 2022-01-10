<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "province";
    protected $guarded = ['id'];
    public $timestamps = false;
}
