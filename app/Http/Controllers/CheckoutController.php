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
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
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
        ->where('contact.pick', '=', '1')
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
        CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
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
            $data_pengirim = $response['rajaongkir']['results'];
            return $data_pengirim;
        }
    }
    public function get_city($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?&province=$id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
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
            $data_kota = $response['rajaongkir']['results'];
            return json_encode($data_kota);
        }
    }
    public function get_ongkir($origin, $destination, $weight, $courier){
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=$origin&originType=city&destination=$destination&destinationType=subdistrict&weight=$weight&courier=$courier",
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
            $data_ongkir = $response['rajaongkir']['results'];
            return json_encode($data_ongkir);
        }
    }
    public function changepick(Request $request)
    {
        // dd($request->nama_kota);
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
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
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
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
            'id_user' => session('user-session')->id,
            'id_address' => $req->id_address,
            'total_berat' => $req->berat,
            'total_ongkir' => $req->ongkir,
            'etd' => $req->etd,
            'kurir' => $req->kurir,
            'total' => $req->total,
        ]);
        $hsl3 = Cart::where('id_user', session('user-session')->id)->update([
            'status' => '0'
        ]);
        $hsl4 = Dumy::where('id_transaction', session('id_transaction'))->delete();
        if ($hsl && $hsl2 && $hsl3 && $hsl4) {
            $hsl3 = Payget::create([
                'id_transaction' =>  $req->id_transaction,
                'id_user' => session('user-session')->id,
                'name' => 'Ongkir',
                'quantity' => '1',
                'price' =>  $req->ongkir
            ]);
            return redirect()->back()->with(['message' => 'Barang berhasil diproses', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Barang gagal diproses', 'alert' => 'danger']);
        }
    }

}
