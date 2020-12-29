<?php

namespace App\Http\Controllers;

use App\Penjualan;
use Illuminate\Http\Request;

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

        return view('penjualan.index', [
            'page' => $this->page,
            'penjualans' => $penjualans
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
}
