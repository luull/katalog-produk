<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListTransaction extends Model
{
    protected $table = "list_transaction";
    protected $guarded = ['id'];
    public $timestamps = false;
}

