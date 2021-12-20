<?php

namespace App\Http\Controllers;

use App\Cart;
use App\DefaultProduct;
use App\Dumy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $countcart = Cart::where('id_user', session('user-session')->id)->count();
        session(['countcart' => $countcart]);
        $data = DB::table('default_produk')
        ->join('cart', 'cart.id_barang', '=', 'default_produk.id')
        ->select('default_produk.nama_brg', 'default_produk.foto', 'default_produk.slug', 'default_produk.keterangan_singkat', 'default_produk.harga', 'cart.id','cart.qty','cart.id_user','cart.id_barang','cart.status')
        ->where('cart.id_user', session('user-session')->id)
        ->orderBy('cart.id', 'DESC')
        ->get();
        $dummy = DB::table('default_produk')
        ->join('dummy', 'dummy.id_barang', '=', 'default_produk.id')
        ->select('default_produk.nama_brg', 'default_produk.foto', 'default_produk.slug', 'default_produk.keterangan_singkat', 'default_produk.harga', 'dummy.id','dummy.qty','dummy.id_user','dummy.id_barang','dummy.total')
        ->where('dummy.id_user', session('user-session')->id)
        ->orderBy('dummy.id', 'DESC')
        ->get();
        $countbuy = Dumy::where('id_user', session('user-session')->id)->count();
        $sum = Dumy::where('id_user', session('user-session')->id)->sum('total');

        return view("pages.cart", compact('data','countbuy','dummy','sum'));
    }
    public function create(Request $req)
    {
        $validasi = Cart::where('id_barang', $req->id_barang)->first();
        if($validasi){
            $tambah = $validasi->qty + $req->qty;
            $hsl = Cart::where('id', $validasi->id)->update([
                'qty' => $tambah
            ]);
            if($hsl){
                return redirect('/cart')->with(['message' => 'Barang berhasil ditambah ke keranjang', 'alert' => 'success']);
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
    }
    public function delete(Request $req)
    {
        $hsl = Cart::find($req->id)->delete();
        if ($hsl) {
            return redirect()->back()->with(['message' => 'Barang berhasil dihapus dari keranjang', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Barang gagal dihapus dari keranjang', 'alert' => 'danger']);
        }
    }
    public function dummy(Request $req)
    {
        $getcart = Cart::where('id_barang', $req->id_barang)->first();
        $getprice = DefaultProduct::where('id', $req->id_barang)->first();
        $total = $getprice->harga * $getcart->qty;
        $hsl = Dumy::create([
            'id_user' => $getcart->id_user,
            'id_barang' => $getcart->id_barang,
            'qty' => $getcart->qty,
            'total' => $total
        ]);
        $hsl2 = Cart::where('id', $getcart->id)->update([
            'status' => '1'
        ]);
        if($hsl && $hsl2){
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }
    public function deletedummy(Request $req)
    {
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
