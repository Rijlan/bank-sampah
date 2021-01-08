<?php

namespace App\Http\Controllers;

use App\JenisSampah;
use App\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->page = [
            'active' => 'penjualan'
        ];
    }

    public function index()
    {
        $penjualans = Penjualan::all();
        $jenis_sampahs = JenisSampah::all();

        $totals = DB::select(DB::raw("SELECT jenis_sampahs.jenis, SUM(berat) AS berat FROM penjualans LEFT JOIN jenis_sampahs ON penjualans.jenis_sampah_id = jenis_sampahs.id GROUP BY jenis_sampahs.jenis"));

        $grand_total = Penjualan::sum('berat');

        return view('penjualan.index', [
            'page' => $this->page,
            'penjualans' => $penjualans,
            'jenis_sampahs' => $jenis_sampahs,
            'totals' => $totals,
            'grand_total' => $grand_total
        ]);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        try {
            $penjualan->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect()->back()->with('message', 'Berhasil Dihapus');
    }

    public function store(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'nama_pengepul' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telpon' => 'required|string|max:255',
            'jenis_sampah_id' => 'required|integer',
            'berat' => 'required|integer',
        ]);

        $penjualan->nama_pengepul = $request->nama_pengepul;
        $penjualan->alamat = $request->alamat;
        $penjualan->telpon = $request->telpon;
        $penjualan->jenis_sampah_id = $request->jenis_sampah_id;
        $penjualan->berat = $request->berat;

        try {
            $penjualan->save();
            
            return redirect()->back()->with('message', 'Penjualan Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
