<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productController extends Controller
{
    public function index()
    {
        if (empty(session('backend-session'))) {
            return redirect('/login/backend');
        }
        $data = DB::table('product')
            ->join('category', 'category.id', '=', 'product.kategori')
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_kategori')
            ->select('product.*','product.id as pid','category.name as n','sub_category.*')
            ->orderBy('product.id', 'DESC')
            ->get();
        $category = Category::all();
        $subcategory = SubCategory::all();
        return view('backend.pages.product', compact('data','category','subcategory'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'berat' => 'required',
            'harga' => 'required',
            'keterangan_singkat' => 'required',
            'keterangan' => 'required',
            'kategori' => 'required',
            'sub_kategori' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = '';
        if ($request->hasfile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('backend/product'), $imageName);
            $image = "backend/product/$imageName";
        }
        $hsl = Product::create([
            'name' => $request->name,
            'berat' => $request->berat,
            'harga' => $request->harga,
            'keterangan_singkat' => $request->keterangan_singkat,
            'keterangan' => $request->keterangan,
            'kategori' => $request->kategori,
            'sub_kategori' => $request->sub_kategori,
            'image' => $image,
            'created_by' => session('backend-session')->username
        ]);
        if($hsl){
            return redirect()->back()->with(['message' => 'product has been created', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'product failed created', 'color' => 'alert-danger']);
        }
    }
    public function find(Request $req)
    {
        $hsl = Product::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'berat' => 'required',
            'harga' => 'required',
            'keterangan_singkat' => 'required',
            'keterangan' => 'required',
            'kategori' => 'required',
            'sub_kategori' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = '';
        if ($request->hasfile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('backend/product'), $imageName);
            $image = "backend/product/$imageName";
        }else {
           $image = $request->default;
        }
        $hsl = Product::find($request->id)->update([
            'name' => $request->name,
            'berat' => $request->berat,
            'harga' => $request->harga,
            'keterangan_singkat' => $request->keterangan_singkat,
            'keterangan' => $request->keterangan,
            'kategori' => $request->kategori,
            'sub_kategori' => $request->sub_kategori,
            'image' => $image,
        ]);
        if($hsl){
            return redirect()->back()->with(['message' => 'product has been updated', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'product failed updated', 'color' => 'alert-danger']);
        }
    }
    public function delete(Request $request)
    {
        $get = Product::where('id', $request->id)->first();
        $hsl = unlink(public_path($get->image));
        if($hsl){
            Product::find($request->id)->delete();
            return redirect()->back()->with(['message' => 'product has been deleted', 'color' => 'alert-success']);
        }else{
            return redirect()->back()->with(['message' => 'product failed deleted', 'color' => 'alert-danger']);
        }
    }
}
