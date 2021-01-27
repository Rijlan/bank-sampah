<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Catatan;
use App\Chat;
use App\Http\Resources\CatatanResource;
use App\Http\Resources\PenjemputanResource;
use App\JenisSampah;
use App\Penjemputan;
use App\Tabungan;
use App\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiNasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        $debit = Tabungan::where('user_id', Auth::id())->sum('debit');
        $kredit = Tabungan::where('user_id', Auth::id())->sum('kredit');
        $duit = $debit - $kredit;
        $uang = number_format("$duit", 0, ",", ".");

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
        $debit = Tabungan::where('user_id', Auth::id())->sum('debit');
        $kredit = Tabungan::where('user_id', Auth::id())->sum('kredit');

        if (empty($uang)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'data' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'debit' => $debit,
            'kredit' => $kredit,
            'uang' => $uang,
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function riwayatBarang()
    {
        $data = Catatan::where('user_id', Auth::id())->get();

        $barang = CatatanResource::collection($data);
        $barang = $barang->sortByDesc('created_at');
        $barang = $barang->values()->all();


        // $barang = Catatan::select('jenis_barangs.jenis', 'tabungans.dabit', 'tabungans.kredit', 'catatans.berat','catatans.jenis_barang_id')
        // ->join('jenis_barangs', 'jenis_barangs.id', '=', 'catatans.jenis_barang_id')
        // ->join('tabungans', 'tabungans.user_id', '=', 'catatans.user_id')
        // ->where('catatans.user_id', '=', Auth::id())
        // ->get();

        // $catatan = ;

        // $jenis_sampah = JenisSampah::first();
        // $catatan = Catatan::where('user_id', Auth::id())->first();
        // $tabungan = Tabungan::with('catatan')->first();
        // $barang = $tabungan->catatan->with('jenisSamapah')->get();
        // $barang = Tabungan::whereHas('catatan', function ($query) {
        //     $query->with('jenisSampah')->get();
        // })->get();

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
    public function penjemput()
    {

        $penjemput = User::where('role', 1)->get();

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestPenjemputan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'url_alamat' => 'required',
            'telpon' => 'required',
            'foto' => 'required',
            'penjemput_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $foto = null;

        if ($request->foto) {

            $foto = Cloudinary::upload($request->file('foto')->getRealPath())->getSecurePath();

            // $img = base64_encode(file_get_contents($request->foto));
            // $client = new Client();
            // $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
            //     'form_params' => [
            //         'key' => '6d207e02198a847aa98d0a2a901485a5',
            //         'action' => 'upload',
            //         'source' => $img,
            //         'format' => 'json',
            //     ]
            // ]);
            // $array = json_decode($res->getBody()->getContents());
            // $foto = $array->image->file->resource->chain->image;
        }

        $penjemput = Penjemputan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'url_alamat' => $request->url_alamat,
            'telpon' => $request->telpon,
            'foto' => $foto,
            'status' => 1,
            'user_id' => Auth::id(),
            'penjemput_id' => $request->penjemput_id,
        ]);

        $pesan = Chat::create([
            'from' => Auth::id(),
            'to' => $request->penjemput_id,
            'status' => 1,
            'pesan' => 'Saya Telah Mengirim Form Penjemputan, Mohon Segera Dijemput',
        ]);

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
            'penjemput' => $penjemput,
            'pesan' => $pesan,
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function riwayatPenjemputan()
    {

        $data = Penjemputan::where('user_id', Auth::id())->get();
        $penjemput = PenjemputanResource::collection($data);
        $penjemput = $penjemput->sortBy('status');
        $penjemput = $penjemput->values()->all();

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailRiwayatPenjemputan($id)
    {

        $data = Penjemputan::where('user_id', Auth::id())->where('id', $id)->first();

        if (empty($data)) {
            return response()->json([
                'status' => 'failed',
                'message' => "data tidak tersedia",
                'data' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'data' => $data
        ], 200);
    }

    public function peringkat()
    {
        // 5 peringkat
        $peringkat = DB::select(DB::raw("SELECT users.name, SUM(berat) AS total_berat, SUM(catatans.total) AS total_harga FROM users LEFT JOIN catatans ON users.id = catatans.user_id LEFT JOIN jenis_sampahs ON catatans.jenis_sampah_id = jenis_sampahs.id WHERE users.role = 3 GROUP BY users.name ORDER BY total_harga DESC"));


        if (empty($peringkat)) {
            return response()->json([
                'status' => 'failed',
                'message' => "peringkat tidak tersedia",
                'peringkat' => null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'peringkat tersedia',
            'peringkat' => $peringkat
        ], 200);
    }
}
