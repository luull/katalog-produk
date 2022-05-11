<?php

namespace App\Http\Controllers;

use App\Cart;
use App\City;
use App\Contact;
use App\DefaultProduct;
use App\Product;
use App\Province;
use App\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {
        if(session('user-session') != null){
            $countcart = Cart::where('id_user', session('user-session')->id)->count();
            session(['countcart' => $countcart]);
        }else {
            $countcart = 'kosong';
            session(['countcart' => $countcart]);
        }
        $produk_display = DB::table('product')
        ->join('display', 'display.produk_id', '=', 'product.id')
        ->select('product.*','product.id as idprod','display.id')
        ->orderBy('display.id', 'DESC')
        ->get();
        $product = Product::get();
        return view("pages.home", compact('product','produk_display'));
    }
    public function city_list(Request $req)
    {
        $get = Province::where('province', $req->id)->first()->id;
        $city = City::where('province_id', $get)->get();
        if (count($city) > 0) {
            $data = array(
                'code' => 200,
                'result' => $city
            );
            $code = 200;
        } else {
            $code = 404;
            $data = array(
                'code' => 404,
                'error' => 'Province ID not Found'
            );
        }
        return  response()->json($data, $code);
    }
    public function subdistrict_list(Request $req)
    {
        $kec = Subdistrict::where('city_id', $req->id)->get();
        if (count($kec) > 0) {
            $data = array(
                'code' => 200,
                'result' => $kec
            );
            $code = 200;
        } else {
            $code = 404;
            $data = array(
                'code' => 404,
                'error' => 'City ID not Found'
            );
        }

        return  response()->json($data, $code);
    }
}
