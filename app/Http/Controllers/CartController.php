<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Contact;
use App\Product;
use App\Dumy;
use App\Payget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
        $countcart = Cart::where('id_user', session('user-session')->id)->count();
        session(['countcart' => $countcart]);
        $data = DB::table('product')
        ->join('cart', 'cart.id_barang', '=', 'product.id')
        ->select('product.*','product.id as pid','cart.id as cid','cart.qty','cart.id_user','cart.id_barang','cart.status')
        ->where('cart.id_user', session('user-session')->id)
        ->orderBy('cart.id', 'DESC')
        ->get();
        $dummy = DB::table('product')
        ->join('dummy', 'dummy.id_barang', '=', 'product.id')
        ->select('product.*','dummy.id','dummy.qty','dummy.id_user','dummy.id_barang','dummy.total')
        ->where('dummy.id_user', session('user-session')->id)
        ->orderBy('dummy.id', 'DESC')
        ->get();
        $countbuy = Dumy::where('id_user', session('user-session')->id)->count();
        $sum = Dumy::where('id_user', session('user-session')->id)->sum('total');

        return view("pages.cart", compact('data','countbuy','dummy','sum'));
    }
    public function create(Request $req)
    {
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
        $validasi = Cart::where('id_user', session('user-session')->id)->first();
        if($validasi){
            $validasi2 = Cart::where('id_barang', $req->id_barang)->first();
            if($validasi2){

                $tambah = $validasi->qty + $req->qty;
                $hsl = Cart::where('id', $validasi->id)->update([
                    'qty' => $tambah
                ]);
                if($hsl){
                    return redirect()->back()->with(['message' => 'Barang berhasil ditambah ke keranjang', 'alert' => 'success']);
                }else{
                    return redirect()->back()->with(['message' => 'Barang gagal ditambah ke keranjang', 'alert' => 'success']);
                }
            }else {
                $hsl = Cart::create([
                    'id_user' => session('user-session')->id,
                    'id_barang' => $req->id_barang,
                    'qty' => $req->qty
                ]);
                if($hsl){
                    return redirect('/cart')->with(['message' => 'Barang berhasil ditambah ke keranjang', 'alert' => 'success']);
                }else{
                    return redirect()->back()->with(['message' => 'Barang gagal ditambah ke keranjang', 'alert' => 'success']);
                }
            }
        }else {
            $hsl = Cart::create([
                'id_user' => session('user-session')->id,
                'id_barang' => $req->id_barang,
                'qty' => $req->qty
            ]);
            if($hsl){
                return redirect('/cart')->with(['message' => 'Barang berhasil ditambah ke keranjang', 'alert' => 'success']);
            }else{
                return redirect()->back()->with(['message' => 'Barang gagal ditambah ke keranjang', 'alert' => 'success']);
            }
        }
    }
    public function delete(Request $req)
    {
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
        $hsl = Cart::find($req->id)->delete();
        if ($hsl) {
            return redirect()->back()->with(['message' => 'Barang berhasil dihapus dari keranjang', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Barang gagal dihapus dari keranjang', 'alert' => 'danger']);
        }
    }
    public function dummy(Request $req)
    {
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
        $getcart = Cart::where('id_user', '=', session('user-session')->id)
        ->where('id_barang','=', $req->id_barang)
        ->first();
        $getprice = Product::where('id', $req->id_barang)->first();
        $total = $getprice->harga * $getcart->qty;
        $berat = $req->berat * $getcart->qty;
        $a = session('user-session')->id.rand(2,50).date('d-m-Y');
        $b = str_replace("-","",$a);
        $transaction = 'TR-' . str_replace(".","-",$b);
        $validate = Dumy::where('id_user', session('user-session')->id)->first();
        $getbarang = Product::where('id', $getcart->id_barang)->first();
        if($validate){
            $hsl = Dumy::create([
                'id_transaction' => $validate->id_transaction,
                'id_user' => $getcart->id_user,
                'id_barang' => $getcart->id_barang,
                'qty' => $getcart->qty,
                'berat' => $berat,
                'total' => $total
            ]);
            $hsl3 = Payget::create([
                'id_transaction' => $validate->id_transaction,
                'id_user' => $getcart->id_user,
                'name' => $getbarang->name,
                'quantity' => $getcart->qty,
                'price' => $getprice->harga
            ]);
        }else{
            $hsl = Dumy::create([
                'id_transaction' => $transaction,
                'id_user' => $getcart->id_user,
                'id_barang' => $getcart->id_barang,
                'qty' => $getcart->qty,
                'berat' => $berat,
                'total' => $total
            ]);
            $hsl3 = Payget::create([
                'id_transaction' => $transaction,
                'id_user' => $getcart->id_user,
                'name' => $getbarang->name,
                'quantity' => $getcart->qty,
                'price' =>  $getprice->harga
            ]);

        }

        $hsl2 = Cart::where('id', $getcart->id)->update([
            'status' => '1'
        ]);


        if($hsl && $hsl2 && $hsl3){
            if($validate){
                session(['id_transaction' => $validate->id_transaction]);
            }else{
                session(['id_transaction' => $transaction]);
            }
            session(['id_cart' => $getcart->id]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }
    public function find(Request $req)
    {
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
        $hsl = Cart::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function updateqty(Request $req)
    {
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
        // dd($req->qty);
        $hsl = Cart::where('id', $req->id)->update([
            'qty' => $req->qty
        ]);
         if($hsl){
                return redirect()->back()->with(['message' => 'Jumlah Barang berhasil diubah', 'alert' => 'success']);
         }else{
                return redirect()->back()->with(['message' => 'Jumlah Barang gagal diubah', 'alert' => 'success']);
         }

            // $hsl = Cart::create([
            //     'id_user' => session('user-session')->id,
            //     'id_barang' => $req->id_barang,
            //     'qty' => $req->qty
            // ]);
            // if($hsl){
            //     return redirect('/cart')->with(['message' => 'Barang berhasil ditambah ke keranjang', 'alert' => 'success']);
            // }else{
            //     return redirect()->back()->with(['message' => 'Barang gagal ditambah ke keranjang', 'alert' => 'success']);
            // }
    }
    public function deletedummy(Request $req)
    {
        if(empty(session('user-session'))){
            return redirect('/');
        }
        if(empty(session('user-session')->id)){
            return redirect('/');
        }
        $getcart = Cart::where('id_barang', $req->id_barang)->first();
        $getdummy = Dumy::where('id_barang', $req->id_barang)->first();
        $hsl = Cart::where('id', $getcart->id)->update([
            'status' => '0'
        ]);
        $hsl2 = Dumy::where('id', $getdummy->id)->delete();
        if($hsl && $hsl2){
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }
}
