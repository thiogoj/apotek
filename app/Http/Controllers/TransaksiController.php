<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function addToCart($id, Request $request) {
        $obat = Obat::find($id);

        $data = Transaksi::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_obat' => $id,
            'jumlah' => $request->jumlah,
            'total' => $request->jumlah * $obat->harga,
            'status' => 'Unordered'
        ]);

        $obat->stok -= $request->jumlah;
        $obat->save();

        if ($data) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        }
    }

    public function deleteCart($id) {
        $data = Transaksi::find($id);

        $obat = Obat::find($data->id_obat);

        $obat->stok += $data->jumlah;
        $obat->save();

        $data->delete();

        if ($data) {
            return response([
                'message' => 'Success'
            ], 200);
        }
    }

    public function editCart($id, Request $request) {
        $data = Transaksi::find($id);

        $obat = Obat::find($data->id_obat);

        $obat->stok += $data->jumlah;
        $obat->save();

        $data->jumlah = $request->jumlah;
        $data->save();

        $obat->stok -= $data->jumlah;
        $obat->save();

        $data->total = $request->jumlah * $obat->harga;
        $data->save();

        if ($data) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        }
    }

    public function cart($id) {
        $data = Transaksi::with(['obat'])->where('id_pelanggan', $id)->where('status', 'Unordered')->get();

        if ($data->isNotEmpty()) {
            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        } else {
            return response([
                'message' => 'Order empty'
            ], 400);
        }
    }

    public function orderCart($id) {
        $data = Transaksi::where('id_pelanggan', $id)->where('status', 'Unordered')->get();

        if ($data->isNotEmpty()) {

            foreach ($data as $datas) {
                $datas->status = "Ordered";
                $datas->save();
            }


            return response([
                'data' => $data,
                'message' => 'Success'
            ], 200);
        } else {
            return response([
                'message' => 'Order empty'
            ], 400);
        }
    }
}
