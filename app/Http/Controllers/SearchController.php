<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\DefaultProduct;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $req)
    {

        if(session('user-session') != null){
            $countcart = Cart::where('id_user', session('user-session')->id)->count();
            session(['countcart' => $countcart]);
        }else {
            $countcart = 'kosong';
            session(['countcart' => $countcart]);
        }
        $search = $req->search;
        if($search === ''){
            redirect('/');
        }
        $category = DB::table('category')
        ->join('sub_category', 'sub_category.id_category', '=', 'category.id')
        ->select('category.*','category.id as cid','sub_category.*')
        ->get();
        $getid = Product::where('name', 'LIKE', '%' . $search . '%')->first();
        // dd($getid->kategori);
        $product = Product::where('name', 'LIKE', '%' . $search . '%')
        ->where('kategori','=', $getid->kategori)
        ->get();
        return view("pages.search", compact('product','search','category','getid'));
    }
    public function defaultproduk(Request $req)
    {
        $product = Product::where('id', $req->id)->first();
        return view("pages.detilProduk", compact('product'));

    }
    public function produk(Request $req)
    {
        $produk = Product::where('id', $req->id)->first();
        return view("pages.detilProduk", compact('produk'));

    }
    public function filter(Request $req)
    {
        $id = $req->id;
        $search = $req->search;
        $product = Product::where('name', 'LIKE', '%' . $search . '%')->get();
        $getid = Product::where('name', 'LIKE', '%' . $search . '%')->first();
        $category = DB::table('category')
        ->join('sub_category', 'sub_category.id_category', '=', 'category.id')
        ->select('category.*','category.id as cid','sub_category.*')
        ->get();
        $getcategory = Category::where('id', $id)->first();
        return view("pages.filter", compact('product','getcategory','category','id','getid'));
    }
}
