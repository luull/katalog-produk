<?php

namespace App\Http\Controllers;

use App\Cart;
use App\DefaultProduct;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {
        if(session('user-session') != null){
            $countcart = Cart::where('id_user', session('user-session')->id)->count();
            session(['countcart' => $countcart]);
        }
        $produk_display = DB::table('default_produk')
        ->join('display', 'display.produk_id', '=', 'default_produk.id')
        ->select('default_produk.nama_brg', 'default_produk.foto', 'default_produk.slug', 'default_produk.keterangan_singkat', 'default_produk.harga', 'display.id')
        ->orderBy('display.id', 'DESC')
        ->get();
        $produk_default = DefaultProduct::get();
        $produk = Product::get();
        return view("pages.home", compact('produk_default','produk_display','produk'));
    }
}
