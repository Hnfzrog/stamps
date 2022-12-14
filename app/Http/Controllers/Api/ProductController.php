<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use Helper;

    public function index() {

    }

    public function create() {

    }

    public function store(Request $request): JsonResponse {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stocks' => 'required',
            'categories' => 'required'
        ]);

        if ($validasi->fails()) {
            return $this->error($validasi->errors()->first());
        }

        // $toko = Product::create($request->all());
        $toko = products::create($request->all());
        return $this->success($toko);
        //
    }

    public function show($id) {
        $alamat = products::where('tokoId', $id)->where('isActive', true)->get();
        return $this->success($alamat);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $alamat = products::where('id', $id)->first();
        if ($alamat) {
            $alamat->update($request->all());
            return $this->success($alamat);
        } else {
            return $this->error("Product tidak ditemukan");
        }
    }

    public function destroy($id) {
        $alamat = products::where('id', $id)->first();
        if ($alamat) {
            $alamat->update([
                'isActive' => false
            ]);
            return $this->success($alamat, "Product berhasil dihapus");
        } else {
            return $this->error("Product tidak ditemukan");
        }
    }

     public function upload(Request $request) {
         $fileName = "";
         if ($request->image) {
             $image = $request->image->getClientOriginalName();
             $image = str_replace(' ', '', $image);
             $image = date('Hs') . rand(1, 999) . "_" . $image;
             $fileName = $image;
             $request->image->storeAs('public/product', $image);

             return $this->success($fileName);
         } else {
             return $this->error("Image wajib di kirim");
         }
     } 
}
