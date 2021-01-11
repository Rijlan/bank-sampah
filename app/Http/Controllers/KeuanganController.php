<?php

namespace App\Http\Controllers;

use App\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function __construct()
    {
        $this->page = [
            'active' => 'keuangan'
        ];
    }

    public function index()
    {
        $keuangans = Keuangan::all();
        $totalDebit = Keuangan::sum('debit');
        $totalKredit = Keuangan::sum('kredit');
        $total = $totalDebit - $totalKredit;

        return view('keuangan.index', [
            'page' => $this->page,
            'keuangans' => $keuangans,
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'total' => $total
        ]);
    }

    public function store(Request $request, Keuangan $keuangan)
    {
        $request->validate([
            'debit' => 'required|integer',
        ]);

        $keuangan->debit = $request->debit;
        $keuangan->keterangan = 0;

        try {
            $keuangan->save();
            
            return redirect()->back()->with('message', 'Saldo Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
