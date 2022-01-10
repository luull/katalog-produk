<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "contact";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function city()
    {
        return $this->hasOne('App\City', 'city_id', 'city');
    }
    public function subdistrict()
    {
        return $this->hasOne('App\Subdistrict', 'subdistrict_id', 'subdistrict');
    }
}
