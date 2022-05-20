<?php

namespace App\Http\Controllers\Auth;

use App\Cart;
use App\Http\Controllers\Controller;
use App\DefaultProduct;
use App\Dumy;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view("pages.login");
    }
    public function regis()
    {
        return view("pages.signup");
    }
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        $uid = $request->name;
        $pwd = $request->password;
        $data = User::where('name', $uid)->first();
        if($data['google_id'] != NULL){
            return redirect()->back()->with('message', 'Akun anda terkait dengan Google');
        }
        if ($data) {
            if (Hash::check($pwd, $data->password)) {
                session(['user-session' => $data]);
                return redirect('/');
            }else{
                return redirect()->back()->with('message', 'Password salah ');
            }
        }else {
            return redirect()->back()->with('message', 'Username salah ');
        }
    }
    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $newUser = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' =>  bcrypt($request->password)
        ]);
        if($newUser){
            return redirect('/login')->with('message', 'Registrasi Berhasil, Silahkan Login ');
        }else{
            return redirect()->back()->with('message', 'Registrasi Gagal');
        }
    }
    public function logout(Request $request)
    {
       Cart::where('id_user', session('user-session')->id)->update([
            'status' => '0'
        ]);
       Dumy::where('id_user', session('user-session')->id)->delete();
        $request->session()->flush();
        return redirect('/')->with('message', 'Berhasil logout');
    }
}
