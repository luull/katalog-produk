<?php

namespace App\Http\Controllers;

use App\Cart;
use App\DefaultProduct;
use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $req)
    {
        $countcart = Cart::where('id_user', session('user-session')->id)->count();
        session(['countcart' => $countcart]);
        $search = $req->search;
        if($search === ''){
            redirect('/');
        }
        $produk_default = DefaultProduct::where('nama_brg', 'LIKE', '%' . $search . '%')->get();
        $produk = Product::where('nama_brg', 'LIKE', '%' . $search . '%')->get();

        return view("pages.search", compact('produk_default','produk','search'));
    }
    public function defaultproduk(Request $req)
    {
        if (session('user-session') == null) {
            return redirect('/');
        }
        $produk_default = DefaultProduct::where('slug', $req->id)->first();
        return view("pages.detilProduk", compact('produk_default'));

    }
    public function produk(Request $req)
    {
        if (session('user-session') == null) {
            return redirect('/');
        }
        $produk = Product::where('slug', $req->id)->first();
        return view("pages.detilProduk", compact('produk'));

    }
}
