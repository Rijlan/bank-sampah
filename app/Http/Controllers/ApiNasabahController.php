<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Catatan;
use App\Http\Resources\CatatanResource;
use App\Penjemputan;
use App\Tabungan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Resource_;

class ApiNasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::id())->get();
        $debit = Tabungan::where('user_id', Auth::id())->sum('debit');
        $kredit = Tabungan::where('user_id', Auth::id())->sum('kredit');
        $duit = $debit-$kredit;
        $uang = $duit;

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
            'uang' => $uang,
            'user' => $user,
        ], 200);

    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function riwayatUang()
   {
       $uang = Tabungan::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();

       if ($uang->isEmpty()) {
           return response()->json([
               'status' => 'failed',
               'message' => "data tidak tersedia",
               'data' => null
           ], 400);
       }

       return response()->json([
           'status' => 'success',
           'message' => 'data tersedia',
           'uang' => $uang
       ], 200);

   }

      /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function riwayatBarang()
    {
   
        $barang = CatatanResource::collection(Catatan::all());
        $barang = $barang->sortByDesc('created_at');
        $barang = $barang->values()->all();
        
        // $barang = Catatan::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();
 
        if (empty($barang)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'data' => null
            ], 400);
        }
 
        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'barang' => $barang
        ], 200);
 
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function penjemputan()
    {

        $penjemput = User::where('role', 1)->get();

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

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function requestPenjemputan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telpon' => 'required',
            'alamat' => 'required',
            'penjemput_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $penjemput = Penjemputan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telpon' => $request->telpon,
            'user_id' => Auth::id(),
            'penjemput_id' => $request->penjemput,
        ]);

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

       /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function riwayatPenjemputan()
    {

        $penjemput = Penjemputan::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();

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
}
