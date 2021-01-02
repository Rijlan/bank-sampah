<?php

namespace App\Http\Controllers;

use App\Keuangan;
use App\User;
use App\Tabungan;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    public function nasabahInfo($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 3) {
            return abort(404);
        }

        $tabungans = Tabungan::where('user_id', $id)->with('user')->orderBy('id', 'ASC')->get();
        $totalDebit = Tabungan::where('user_id', $id)->sum('debit');
        $totalKredit = Tabungan::where('user_id', $id)->sum('kredit');
        $total = $totalDebit - $totalKredit;
        
        return view('nasabah.info' , [
            'page' => ['active' => 'nasabah'],
            'tabungans' => $tabungans,
            'user' => $user,
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'total' => $total
        ]);
    }

    public function nasabahTarik(Request $request, Tabungan $tabungans, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 3) {
            return abort(404);
        }

        $totalDebit = Tabungan::where('user_id', $id)->sum('debit');
        $totalKredit = Tabungan::where('user_id', $id)->sum('kredit');
        $total = $totalDebit - $totalKredit;
        
        $request->validate([
            'kredit' => 'required|integer|min:1000|max:' . $total
        ]);

        $tabungans->user_id = $id;
        $tabungans->kredit = $request->kredit;

        $keuangans = Keuangan::create(['kredit' => $request->kredit]);

        try {
            $tabungans->save();
            
            return redirect()->back()->with('message', 'Penarikan Berhail');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
