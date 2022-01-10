<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    protected $table = "subdistrict";
    protected $guarded = ['id'];
    public $timestamps = false;
}
