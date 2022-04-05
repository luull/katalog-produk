<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Contact;
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
        $getaddress = Contact::select('contact.*','contact.id as ctid', 'city.*','subdistrict.*','users.name')
        ->join('users', 'users.id', '=', 'contact.id_user')
        ->join('city', 'city.city_id', '=', 'contact.city')
        ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
        ->where('contact.id_user', '=', session('user-session')->id)
        ->get();
        $countcart = Cart::where('id_user', session('user-session')->id)->count();
        $resi = session()->get('manifest');
        // dd($resi);
        return view("users.myorder", compact('countcart','transaction','list','product','getaddress'));
    }
    public function cekresi(Request $req){

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "waybill=$req->resi&courier=$req->kurir",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 752483d1f547e051295d7ad5b140b3db"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                    echo "cURL Error #:" . $err;
                    } else {
                        $response=json_decode($response,true);
                        $data_resi = $response['rajaongkir']['result']['manifest'];
                        $noresi = $req->resi;
                        // dd($data_resi);
                        return view("users.tracking", compact('data_resi','noresi'));
                    }
    }
}
