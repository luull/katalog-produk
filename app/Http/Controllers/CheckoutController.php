<?php

namespace App\Http\Controllers;

use App\Cart;
use App\City;
use App\Contact;
use App\DefaultProduct;
use App\Dumy;
use App\Province;
use App\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Snap as MidtransSnap;
use App\ListTransaction;
use App\Payget;
use App\Transaction;
use Exception;
class CheckoutController extends Controller
{
    public function index(Request $req)
    {
        if(empty(session('user-session'))){
            redirect('/');
        }
        elseif(empty(session('user-session')->id)){
            redirect('/');
        }
        $listtransaction = Payget::where('id_transaction', $req->id)->get()->toArray();
        $gettotal = Payget::where('id_transaction', $req->id)->sum('price');
        $getemail = Contact::where('id_user', session('user-session')->id)->first();
        $params = [
        "payment_type" => "bank_transfer",
        "transaction_details" => [
            "gross_amount" => $gettotal,
            "order_id" => $req->id
        ],
        "item_details" => $listtransaction,
        // [
        //     "id" => "1388998298204",
        //     "price" => 10000,
        //     "quantity" => 1,
        //     "name" => "Panci Miako"
        // ],
        'customer_details' => [
            'first_name' => session('user-session')->name,
            'email' => session('user-session')->email,
            'phone' => $getemail->phone,
        ]
    ];
    // dd($params);

     $snapToken = MidtransSnap::getSnapToken($params);
     $getToken = $snapToken->token;
    //  dd($snapToken->token);
    // dd(session('user-session')->id);
        $getcontact = Contact::select('contact.*','contact.id as ctid', 'city.*','subdistrict.*','users.name')
        ->join('users', 'users.id', '=', 'contact.id_user')
        ->join('city', 'city.city_id', '=', 'contact.city')
        ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
        ->where('contact.id_user', '=', session('user-session')->id)
        ->orderBy('contact.status', 'DESC')
        ->get();
        $getaddress = Contact::select('contact.*','contact.id as ctid', 'city.*','subdistrict.*','users.name')
        ->join('users', 'users.id', '=', 'contact.id_user')
        ->join('city', 'city.city_id', '=', 'contact.city')
        ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
        ->where('contact.id_user', '=', session('user-session')->id)
        ->where('contact.pick', '=', 1)
        ->first();
        // $getaddress = Contact::where('pick', 1)->first();
        // $getcontact = Contact::where('id_user', '=' ,session('user-session')->id)->where('status', '=', 1)->get();
        // $city = City::where('city_id', $getcontact->city)->get();
        $countbuy = Dumy::where('id_transaction', $req->id)->count();
        $sum = Dumy::where('id_transaction', $req->id)->sum('total');
        $berat = Dumy::where('id_transaction', $req->id)->sum('berat');
        $getid = $req->id;
        $provinsi = $this->get_province();
        return view("pages.checkout", compact('countbuy','sum','provinsi','getcontact','getaddress','berat','snapToken','getToken','getid'));
    }
    public function get_province(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: 9d96e5bd15910749ba3fc2dbd3fc4761"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //ini kita decode data nya terlebih dahulu
            $response=json_decode($response,true);
            //ini untuk mengambil data provinsi yang ada di dalam rajaongkir resul
            $data_pengirim = $response['rajaongkir']['results'];
            return $data_pengirim;
        }
    }
    public function get_city($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=$id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: 9d96e5bd15910749ba3fc2dbd3fc4761"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response=json_decode($response,true);
            $data_kota = $response['rajaongkir']['results'];
            return json_encode($data_kota);
        }
    }
    public function get_ongkir($origin, $destination, $weight, $courier){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$weight&courier=$courier",
        CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: 9d96e5bd15910749ba3fc2dbd3fc4761"
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response=json_decode($response,true);
            $data_ongkir = $response['rajaongkir']['results'];
            return json_encode($data_ongkir);
        }
    }
    public function changepick(Request $request)
    {
        // dd($request->nama_kota);
        Contact::where('pick', 1)->update([
            'pick' => '0'
        ]);
        $hsl = Contact::where('id', $request->nama_kota)->update([
            'pick' => '1'
        ]);
        if($hsl){
            return redirect()->back()->with(['message' => 'Alamat berhasil diubah', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'Alamat gagal diubah', 'color' => 'alert-danger']);

        }
    }

    public function transaction(Request $req)
    {
        $data = Dumy::where('id_transaction', $req->id_transaction)->get();
        // dd($data);
        foreach ($data as $item)  {
           $hsl = ListTransaction::insert([
            'id_transaction' => $req->id_transaction,
            'id_user' => $item->id_user,
            'id_barang' => $item->id_barang,
            'qty' => $item->qty,
            'berat' => $item->berat,
            'total' => $item->total
           ]);
        }
        $hsl2 = Transaction::insert([
            'id_transaction' => $req->id_transaction,
            'total_berat' => $req->berat,
            'total_ongkir' => $req->ongkir,
            'total' => $req->total,
        ]);
        $hsl3 = Cart::where('id', session('id_cart'))->update([
            'status' => '3'
        ]);
        $hsl4 = Dumy::where('id_transaction', session('id_transaction'))->delete();
        if ($hsl && $hsl2 && $hsl3 && $hsl4) {
            if ($req->session()->has('id_transaction')) {
                $req->session()->forget('id_transaction');
            }elseif ($req->session()->has('id_cart')) {
                $req->session()->forget('id_cart');
            }
            return redirect()->back()->with(['message' => 'Barang berhasil diproses', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Barang gagal diproses', 'alert' => 'danger']);
        }
    }

    // public function bankTransferCharge(Request $req)
    // {
    //     try {
    //     $transaction = array(
    //             "payment_type" => "bank_transfer",
    //             "transaction_details" => [
    //                 "gross_amount" => 10000,
    //                 "order_id" => date('Y-m-dHis')
    //             ],
    //             "customer_details" => [
    //                 "email" => "budi.utomo@Midtrans.com",
    //                 "first_name" => "Azhar",
    //                 "last_name" => "Ogi",
    //                 "phone" => "+628948484848"
    //             ],
    //             "item_details" => array([
    //                 "id" => "1388998298204",
    //                 "price" => 5000,
    //                 "quantity" => 1,
    //                 "name" => "Panci Miako"
    //             ], [
    //                 "id" => "1388998298202",
    //                 "price" => 5000,
    //                 "quantity" => 1,
    //                 "name" => "Ayam Geprek"
    //             ]),
    //             "bank_transfer" => [
    //                 "bank" => "bca",
    //                 "va_number" => "111111",
    //             ]
    //         );
    //         $charge = CoreApi::charge($transaction);
    //         dd($charge->status_code);
    //         if (!$charge) {
    //             return ['code' => 0, 'message' => 'Terjadi kesalahan'];
    //         }
    //         return ['code' => 1, 'message' => 'Success', 'result' => $charge];
    //     } catch (Exception $e) {
    //         return ['code' => 0, 'message' => 'Terjadi kesalahan'];
    //     }
    // }

}
