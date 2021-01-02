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
        $user = User::where('id', Auth::id())->get();

        if ($user->isEmpty()) {
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
        $data = Penjemputan::where('penjemput_id', Auth::id())->where('status', '=', 3)->get();
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
        $user = PenjemputanResource::collection($data);
        $user = $user->sortByDesc('created_at');
        $user = $user->values()->all();

        if (empty($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'user' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'user' => $data,
        ], 200);
    }

    public function terimaJemput($id)
    {
        $user = Penjemputan::where('id', $id)->where('status', '!=', 1)->first();
        $user->status = 2;
        $user->update();

        $pesan = Chat::create([
            'from' => Auth::id(),
            'to' => $user->user_id,
            'status' => 1,
            'pesan' => 'iya pak, kami bersedia melakulan penjemputan ke alamat yang telah bapak kirim, mohon ditunggu ya pak',
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
            'pesan' => $pesan
        ], 200);
    }

    public function selesaiJemput($id)
    {
        $user = Penjemputan::where('id', $id)->where('status', '!=', 2)->first();
        $user->status = 3;
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

    public function tolakJemput($id)
    {
        $user = Penjemputan::where('id', $id)->first();
        $user->status = 4;
        $user->update();

        $pesan = Chat::create([
            'from' => Auth::id(),
            'to' => $user->user_id,
            'status' => 1,
            'pesan' => 'maaf pak, kami belum bersedia melakulan penjemputan ke alamat yang telah bapak kirim karena beberapa alasan, mohon maaf atas keterbasan kami',
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function daftarNasabah()
    {

        $penjemput = User::where('role', 3)->get();

        if ($penjemput->isEmpty()) {
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

        $catatan = Catatan::create([
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'keterangan' => $request->keterangan,
            'berat' => $request->berat,
            'user_id' => $id,
        ]);

        $sampah = JenisSampah::where('id', $request->jenis_sampah_id)->first();

        if ($request->keterangan == 1) {
            $ongkir = $sampah->harga_nasabah * 0.2;
            $uang = Tabungan::create([
                'user_id' => $id,
                'debit' => ($ongkir + $sampah->harga_nasabah) * $request->berat,
                'kredit' => 0,
            ]);
        } else {
            $uang = Tabungan::create([
                'user_id' => $id,
                'debit' => $sampah->harga_nasabah * $request->berat,
                'kredit' => 0,
            ]);
        };

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
