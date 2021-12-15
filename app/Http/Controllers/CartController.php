<?php

namespace App\Http\Controllers;

use App\Cart;
use App\DefaultProduct;
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
        ->select('default_produk.nama_brg', 'default_produk.foto', 'default_produk.slug', 'default_produk.keterangan_singkat', 'default_produk.harga', 'cart.id','cart.qty','cart.id_user')
        ->orderBy('cart.id', 'DESC')
        ->get();
        return view("pages.cart", compact('data'));
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
                return redirect('/cart');
            }else{
                return redirect()->back();
            }
        }else {
            $hsl = Cart::create([
                'id_user' => session('user-session')->id,
                'id_barang' => $req->id_barang,
                'qty' => $req->qty
            ]);
            if($hsl){
                return redirect('/cart');
            }else{
                return redirect()->back();
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
}
