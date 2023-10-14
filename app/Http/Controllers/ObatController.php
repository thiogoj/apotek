<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use FFI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ObatController extends Controller
{
    public function createObat(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
            'gambar' => 'required|mimes:png,jpg,jpeg',
            'keterangan' => 'required',
            'stok' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()
            ], 400);
        }

        $data = Obat::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = Str::random(12) . '.' . $image->getClientOriginalExtension();
            $image->move('gambar/', $imageName);
            $data->gambar = $imageName;
            $data->save();
        }

        return response([
            'data' => $data,
            'message' => 'Success'
        ], 200);
    }

    public function showAll() {
        $data = Obat::get();

        if ($data) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        } else {
            return response([
                'message' => 'Gagal'
            ], 400);
        }
    }

    public function showById($id) {
        $data = Obat::find($id);

        if ($data) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        } else {
            return response([
                'message' => 'Gagal'
            ], 400);
        }
    }

    public function deleteObat($id) {
        $data = Obat::find($id);

        if ($data) {
            $data->delete();
            
            return response([
                'message' => 'Success'
            ], 200);
        } else {
            return response([
                'message' => 'Gagal'
            ], 400);
        }
    }

    public function editObat(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
            'gambar' => 'required|mimes:png,jpg,jpeg',
            'keterangan' => 'required',
            'stok' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()
            ], 400);
        }

        $data = Obat::find($id);

        if ($data) {
                $data->nama = $request->nama;
                $data->kategori = $request->kategori;
                $data->keterangan = $request->keterangan;
                $data->harga = $request->harga;
                $data->stok = $request->stok;
    
            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $imageName = Str::random(12) . '.' . $image->getClientOriginalExtension();
                $image->move('gambar/', $imageName);
                $data->gambar = $imageName;
                $data->save();
            }
    
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        }

        
    }
}
