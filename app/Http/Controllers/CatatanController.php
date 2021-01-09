<?php

namespace App\Http\Controllers;

use App\Catatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatatanController extends Controller
{
    public function __construct()
    {
        $this->page = [
            'active' => 'catatan'
        ];
    }

    public function index()
    {
        $catatans = Catatan::paginate(10);
        $totals = DB::select(
            DB::raw("SELECT jenis_sampahs.jenis, SUM(berat) AS berat FROM catatans LEFT JOIN jenis_sampahs ON catatans.jenis_sampah_id = jenis_sampahs.id GROUP BY jenis_sampahs.jenis")
        );

        $grand_total = Catatan::sum('berat');

        return view('catatan.index', [
            'page' => $this->page,
            'catatans' => $catatans,
            'totals' => $totals,
            'grand_total' => $grand_total
        ]);
    }

    public function destroy($id)
    {
        $catatan = Catatan::findOrFail($id);

        try {
            $catatan->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect()->back()->with('message', 'Berhasil Dihapus');
    }

    public function total()
    {
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

        // 5 peringkat
        $peringkat = DB::select(DB::raw("SELECT users.name, SUM(berat) AS total_berat, SUM(catatans.total) AS total_harga FROM users LEFT JOIN catatans ON users.id = catatans.user_id LEFT JOIN jenis_sampahs ON catatans.jenis_sampah_id = jenis_sampahs.id WHERE users.role = 3 GROUP BY users.name ORDER BY total_harga DESC LIMIT 5"));

        dd($total, $sudah, $belum, $peringkat);
    }
}
