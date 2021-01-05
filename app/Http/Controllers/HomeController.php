<?php

namespace App\Http\Controllers;

use App\Catatan;
use App\Keuangan;
use App\Penjualan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->page = [
            'active' => 'dashboard'
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // total sampah yang pernah didata
        $total = Catatan::sum('berat');

        // total sampah yang sudah dijual
        $sudah = Penjualan::sum('berat');
        
        // total sampah yang belum dijual
        $belum = $total - $sudah;

        // 5 peringkat
        $peringkat = DB::select(DB::raw("SELECT users.name, SUM(berat) AS total_berat, SUM(jenis_sampahs.harga_nasabah * berat) AS total_harga FROM users LEFT JOIN catatans ON users.id = catatans.user_id LEFT JOIN jenis_sampahs ON catatans.jenis_sampah_id = jenis_sampahs.id WHERE users.role = 3 GROUP BY users.name ORDER BY total_harga DESC LIMIT 8"));
        
        $totalDebit = Keuangan::sum('debit');
        $totalKredit = Keuangan::sum('kredit');
        $saldo = $totalDebit - $totalKredit;

        // total sampah yang pernah didata
        $total_sampah = DB::select(DB::raw("SELECT jenis_sampahs.jenis, SUM(berat) AS berat FROM catatans LEFT JOIN jenis_sampahs ON catatans.jenis_sampah_id = jenis_sampahs.id GROUP BY jenis_sampahs.jenis"));

        // total sampah yang sudah dijual
        $total_dijual = DB::select(DB::raw("SELECT jenis_sampahs.jenis, SUM(berat) AS berat FROM penjualans LEFT JOIN jenis_sampahs ON penjualans.jenis_sampah_id = jenis_sampahs.id GROUP BY jenis_sampahs.jenis"));

        
        // total sampah yang belum dijual
        $arr = [];
        foreach ($total_sampah as $key => $value) {
            $arr[$key]['jenis'] = $value->jenis;
            if (empty($total_dijual[$key])) {
                $arr[$key]['berat'] = $value->berat;
            } else {
                $arr[$key]['berat'] = $value->berat - $total_dijual[$key]->berat;
            }
        }

        $tersedia = [];
        foreach ($arr as $to_obj) {
            $tersedia[] = (object) $to_obj;
        }

        return view('admin.index', [
            'page' => $this->page,
            'total' => $total,
            'sudah' => $sudah,
            'belum' => $belum,
            'saldo' => $saldo,
            'peringkat' => $peringkat,
            'tersedia' => $tersedia
        ]);
    }

    public function profile()
    {
        $user = User::findOrFail(Auth::user()->id);
        
        return view('admin.profile', [
            'page' => ['active' => 'profile'],
            'user' => $user
        ]);
    }

    public function change(Request $request, User $user)
    {
        $request->validate([
            'old_password' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:8|confirmed'
        ]);
        
        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->password);

            try {
                $user->save();

                return redirect()->back()->with('message', 'Password Berhasil Diubah');
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        } else {
            return redirect()->back()->withErrors('Password Salah');
        }
    }
}
