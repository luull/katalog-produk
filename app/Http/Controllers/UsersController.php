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
        $contact = Contact::select('contact.*','contact.id as idny', 'city.*','subdistrict.*')
        ->join('city', 'city.city_id', '=', 'contact.city')
        ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
        ->where('contact.id_user', '=', $countcontact->id_user)
        ->orderBy('status', 'DESC')
        ->get();
        $getuser = User::where('id', $countcontact->id_user)->first();
        // $contact = Contact::where('id_user', session('user-session')->id)->get();
        $province = Province::get();
        $city = City::get();
        $subdistrict = Subdistrict::get();
        return view('users.dashboard', compact('data','contact','province','city', 'subdistrict','countcontact','getuser'));
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
            return redirect()->back()->with(['message' => 'Avatar berhasil diubah', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'Avatar gagal diubah', 'color' => 'alert-danger']);

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
            return redirect()->back()->with(['message' => 'Data berhasil ditambahkan', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'Data gagal ditambahkan', 'color' => 'alert-danger']);

        }
        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }
    public function updatestatus(Request $request){
        try {
            Contact::where('status', 1)->update([
                'status' => '0'
            ]);
        $hsl = Contact::where('id', $request->id)->update([
            'status' => '1'
        ]);
        if($hsl){
            return redirect()->back()->with(['message' => 'Alamat berhasil di set', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'Alamat gagal di set', 'color' => 'alert-danger']);

        }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function find(Request $req)
    {
        $hsl = Contact::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function delete(Request $req)
    {
        $hsl = Contact::find($req->id)->delete();
        if ($hsl) {
            return redirect()->back()->with(['message' => 'Data berhasil dihapus', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'Data gagal dihapus', 'color' => 'alert-danger']);
        }
    }

}
