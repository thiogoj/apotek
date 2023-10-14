<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerPegawai(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'password' => 'required|min:3',
            'level' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'gaji' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()
            ], 400);
        }

        $data = Pegawai::create([
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level' => $request->level,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'gaji' => $request->gaji
        ], 200);

        if ($data) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        }
    }

    public function loginPegawai(Request $request) {
        $data = Pegawai::where('nama', $request->nama)->first();

        if ($data && Hash::check($request->password, $data->password)) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        } else {
            return response([
                'message' => 'Failed to login'
            ], 400); 
        }
    }

    public function registerPelanggan(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'password' => 'required|min:3',
            'gender' => 'required',
            'alamat' => 'required',
            'pekerjaan' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()
            ], 400);
        }

        $data = User::create([
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
        ], 200);

        if ($data) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        }
    }

    public function loginPelanggan(Request $request) {
        $data = User::where('nama', $request->nama)->first();

        if ($data && Hash::check($request->password, $data->password)) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        } else {
            return response([
                'message' => 'Failed to login'
            ], 400); 
        }
    }
}
