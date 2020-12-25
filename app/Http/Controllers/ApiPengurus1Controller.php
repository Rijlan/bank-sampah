<?php

namespace App\Http\Controllers;

use App\Catatan;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PenjemputanResource;
use App\JenisSampah;
use App\Penjemputan;
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

    public function mintaJemput()
    {
        $data = Penjemputan::where('penjemput_id', Auth::id())->where('status', 1)->get();
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

    public function dataJemput()
    {
        $data = Penjemputan::where('penjemput_id', Auth::id())->where('status', '!=', 1)->get();
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

    public function pendataan()
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

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $catatan = Catatan::create([
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'keterangan' => $request->keterangan,
            'berat' => $request->berat,
            'user_id' => $id,
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
        ], 200);

    }

}
