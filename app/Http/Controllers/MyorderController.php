<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Dumy;
use Illuminate\Http\Request;
use App\Http\Controllers\Midtrans\Snap as MidtransSnap;
use App\ListTransaction;
use App\Payget;
use App\Product;
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
        if ($req->session()->has('id_transaction')) {
            $req->session()->forget('id_transaction');
        }elseif ($req->session()->has('id_cart')) {
            $req->session()->forget('id_cart');
        }
        $transaction = Transaction::where('id_user', session('user-session')->id)->get();
        $list = ListTransaction::where('id_user', session('user-session')->id)->get();
        $product = Product::all();
        $countcart = Cart::where('id_user', session('user-session')->id)->count();
        return view("users.myorder", compact('countcart','transaction','list','product'));
    }
}
