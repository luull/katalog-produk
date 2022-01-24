<?php

namespace App\Http\Controllers;

use App\Dumy;
use Illuminate\Http\Request;
use App\Http\Controllers\Midtrans\Snap as MidtransSnap;
use App\Payget;
use App\Transaction;
use Exception;
class MyorderController extends Controller
{
    public function index(Request $req)
    {
        if(empty(session('user-session'))){
            redirect('/');
        }
        elseif(empty(session('user-session')->id)){
            redirect('/');
        }
        $countbuy = Dumy::where('id_transaction', $req->id)->count();
        return view("users.myorder", compact('countbuy'));
    }
}
