<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\DefaultProduct;
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
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/')->with('message', 'Berhasil logout');
    }
}
