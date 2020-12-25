<?php

namespace App\Http\Controllers;

use App\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function __construct()
    {
        $this->page = [
            'active' => 'jenis sampah'
        ];
    }
    public function index()
    {
        $jenis_sampahs = JenisSampah::all();

        return view('jenis.index', [
            'page' => $this->page,
            'jenis_sampahs' => $jenis_sampahs
        ]);
    }

    public function destroy($id) {
        $jenis_sampah = JenisSampah::findOrFail($id);

        try {
            $jenis_sampah->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect()->back()->with('message', 'Berhasil Dihapus');
    }
    
    public function store(Request $request, JenisSampah $jenis_sampah)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
            'harga_nasabah' => 'required|integer',
            'harga_pengepul' => 'required|integer',
        ]);

        $jenis_sampah->jenis = $request->jenis;
        $jenis_sampah->harga_nasabah = $request->harga_nasabah;
        $jenis_sampah->harga_pengepul = $request->harga_pengepul;

        try {
            $jenis_sampah->save();
            
            return redirect()->back()->with('message', 'Jenis Sampah Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function update(Request $request, JenisSampah $jenis_sampah, $id)
    {
        $jenis_sampah = JenisSampah::findOrFail($id);

        $request->validate([
            'jenis' => 'required|string|max:255',
            'harga_nasabah' => 'required|integer',
            'harga_pengepul' => 'required|integer',
        ]);

        $data = $request->all();
        $result = array_filter($data);

        try {
            $jenis_sampah->update($result);
            
            return redirect()->back()->with('message', 'Jenis Sampah Berhasil Diupdate');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
