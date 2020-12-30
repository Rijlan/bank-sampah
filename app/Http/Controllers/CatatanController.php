<?php

namespace App\Http\Controllers;

use App\Catatan;
use Illuminate\Http\Request;

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
        $catatans = Catatan::all();

        return view('catatan.index', [
            'page' => $this->page,
            'catatans' => $catatans
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
}
