<?php

namespace App\Http\Controllers;

use App\Contact;
use App\User;
use App\Users;
use App\City;
use App\Province;
use App\Subdistrict;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $data = User::where('id', session('user-session')->id)->first();
        $countcontact = Contact::where('id_user', session('user-session')->id)->first();
        $getuser = User::where('id', $countcontact->id_user)->first();
        $getcity = City::where('city_id', $countcontact->city)->first();
        $getsubdistrict = Subdistrict::where('subdistrict_id', $countcontact->subdistrict)->first();
        $contact = Contact::where('id_user', session('user-session')->id)->get();
        $province = Province::get();
        $city = City::get();
        return view('users.dashboard', compact('data','contact','province','city', 'countcontact','getuser','getcity','getsubdistrict'));
    }
    public function updateavatar(Request $request){
        // $request->validate([
        //     'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        try {
        $photo = '';
        if ($request->hasfile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $uid = session('user-session')->google_id;
            $request->photo->move(public_path($uid.'/images'), $photoName);
            $photo = "$uid/images/$photoName";
        }else {
            $photo = $request->default;
        }
        $hsl = Users::find($request->id)->update([
            'photo' => $photo,
        ]);
        if($hsl){
            return redirect()->back()->with(['message' => 'Data has been updated', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'Data has been updated', 'color' => 'alert-danger']);

        }
        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }
    public function addcontact(Request $request){
        try {
        $request->validate([
            'category' => 'required',
            'propinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'phone' => 'required',
            'alamat' => 'required',
        ]);
        if (substr($request->phone, 0, 2) != '62') {
            $phonenum = "62" . substr($request->phone, 1);
        } else {
            $phonenum = $request->phone;
        }
        $hsl = Contact::create([
            'id_user' => session('user-session')->id,
            'category' => $request->category,
            'province' => $request->propinsi,
            'city' => $request->kota,
            'subdistrict' => $request->kecamatan,
            'phone' => $phonenum,
            'address' => $request->alamat,
            'kd_pos' => $request->kd_pos,
        ]);
        if($hsl){
            return redirect()->back()->with(['message' => 'Data has been updated', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'Data has been updated', 'color' => 'alert-danger']);

        }
        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }

}
