<?php

namespace App\Http\Controllers;

use App\Catatan;
use App\JenisSampah;
use App\Penjualan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiPengurus2Controller extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        // total sampah yang pernah didata
        $total = DB::select(DB::raw("SELECT jenis_sampahs.jenis, SUM(berat) AS berat FROM catatans LEFT JOIN jenis_sampahs ON catatans.jenis_sampah_id = jenis_sampahs.id GROUP BY jenis_sampahs.jenis"));

        // total sampah yang sudah dijual
        $sudah = DB::select(DB::raw("SELECT jenis_sampahs.jenis, SUM(berat) AS berat FROM penjualans LEFT JOIN jenis_sampahs ON penjualans.jenis_sampah_id = jenis_sampahs.id GROUP BY jenis_sampahs.jenis"));


        // total sampah yang belum dijual
        $arr = [];
        foreach ($total as $key => $value) {
            $arr[$key]['jenis'] = $value->jenis;
            if (empty($sudah[$key])) {
                $arr[$key]['berat'] = $value->berat;
            } else {
                $arr[$key]['berat'] = $value->berat - $sudah[$key]->berat;
            }
        }

        $belum = [];
        foreach ($arr as $to_obj) {
            $belum[] = (object) $to_obj;
        }


        if (empty($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'data' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'user' => $user,
            'belum' => $belum,
            // 'sudah' => $sudah,
            // 'total' => $total,
        ], 200);
    }

    public function penjualan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengepul' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'jenis_sampah_id' => 'required',
            'berat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $form = $validator->validated();
        $sampah = JenisSampah::where('id', $request->jenis_sampah_id)->firstOrFail();

        $penjualan = Penjualan::create(
            array_merge(
                $form,
                [
                    'total' => $sampah->harga_pengepul * $form['berat'],
                ]
            )
        );

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'data' => $penjualan,
        ], 200);
    }

    public function riwayatPenjualan()
    {
        $penjualan = Penjualan::get();

        if(empty($penjualan)){
            return response()->json([
                'status' => 'failed',
                'message' => 'data tidak tersedia',
                'data' => null,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'data' => $penjualan,
        ], 200);
    }

    public function detailRiwayatPenjualan($id)
    {
        $penjualan = Penjualan::where('id', $id)->firstOrFail();

        if(empty($penjualan)){
            return response()->json([
                'status' => 'failed',
                'message' => 'data tidak tersedia',
                'data' => null,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'data' => $penjualan,
        ], 200);
    }
}
