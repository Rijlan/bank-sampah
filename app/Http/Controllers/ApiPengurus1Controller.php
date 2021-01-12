<?php

namespace App\Http\Controllers;

use App\Catatan;
use App\Chat;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PenjemputanResource;
use App\JenisSampah;
use App\Penjemputan;
use App\Tabungan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiPengurus1Controller extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->first();

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
        ], 200);
    }

    public function dataJemput()
    {
        $data = Penjemputan::where('penjemput_id', Auth::id())->where('status', '=', 1)->get();
        $user = PenjemputanResource::collection($data);
        $user = $user->sortByDesc('created_at');
        $user = $user->values()->all();

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
        ], 200);
    }

    public function harusJemput()
    {
        $data = Penjemputan::where('penjemput_id', Auth::id())->where('status', '=', 2)->get();
        $user = PenjemputanResource::collection($data);
        $user = $user->sortByDesc('created_at');
        $user = $user->values()->all();

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
        ], 200);
    }

    public function riwayatJemput()
    {
        $data = Penjemputan::where('penjemput_id', Auth::id())->where('status', '=', 4)->get();
        $user = PenjemputanResource::collection($data);
        $user = $user->sortByDesc('created_at');
        $user = $user->values()->all();

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
        ], 200);
    }
    public function detailDataJemput($id)
    {
        $data = Penjemputan::where('penjemput_id', Auth::id())->where('id', $id)->first();

        if (empty($data)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'user' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'data' => $data,
        ], 200);
    }

    public function terimaJemput($id)
    {
        $user = Penjemputan::where('id', $id)->firstOrFail();
        $user->update(['status' => 2]);

        $pesan = Chat::create([
            'from' => Auth::id(),
            'to' => $user->user_id,
            'status' => 1,
            'pesan' => 'Baik, Penjemputan Akan Segera kami Lakukan',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'user' => $user,
            'pesan' => $pesan
        ], 200);
    }


    public function tolakJemput($id)
    {
        $user = Penjemputan::where('id', $id)->first();
        $user->status = 3;
        $user->update();

        $pesan = Chat::create([
            'from' => Auth::id(),
            'to' => $user->user_id,
            'status' => 1,
            'pesan' => 'Maaf, Pemintaan Anda Tidak Bisa Kami Lakukan',
        ]);

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
            'pesan' => $pesan,
        ], 200);
    }

    public function selelsaiJemput($id)
    {
        $user = Penjemputan::where('id', $id)->first();
        $user->status = 4;
        $user->update();

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
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function daftarNasabah()
    {

        $penjemput = User::where('role', 3)->get();

        if (empty($penjemput)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'data' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'penjemput' => $penjemput
        ], 200);
    }

    public function cariNasabah($user)
    {

        $user = User::where('email', $user)->first();

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
        ], 200);
    }

    public function jenisSampah()
    {
        $jenissampah = JenisSampah::get();
        if (empty($jenissampah)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'data' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'jenissampah' => $jenissampah,
        ], 200);
    }

    public function pencatatan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_sampah_id' => 'required',
            'keterangan' => 'required',
            'berat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $sampah = JenisSampah::where('id', $request->jenis_sampah_id)->first();

        if ($request->keterangan == 1) {
            $ongkir = $sampah->harga_nasabah * 0.2;
            $catatan = Catatan::create([
                'jenis_sampah_id' => $request->jenis_sampah_id,
                'keterangan' => $request->keterangan,
                'berat' => $request->berat,
                'total' => ($sampah->harga_nasabah - $ongkir) * $request->berat,
                'user_id' => $id,
            ]);
        } else {
            $catatan = Catatan::create([
                'jenis_sampah_id' => $request->jenis_sampah_id,
                'keterangan' => $request->keterangan,
                'berat' => $request->berat,
                'total' => $request->harga_nasabah * $request->berat,
                'user_id' => $id,
            ]);
        };

        $uang = Tabungan::create([
            'user_id' => $id,
            'debit' => $catatan->total,
            'kredit' => 0,
        ]);

        if (empty($catatan)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'data' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'catatan' => $catatan,
            'uang' => $uang,
        ], 200);
    }
}
