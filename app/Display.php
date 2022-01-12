<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Display extends Model
{
    protected $table = "display";
    protected $guarded = ['id'];
    public $timestamps = false;
}
