<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiChatController extends Controller
{
    public function kontakNasabah()
    {
        $user = User::where('role', 1)->get();
        if (empty($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data tidak tersedia',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'data' => $user
        ]);
    }

    public function kontakPengurus1()
    {
        $from = DB::table('users')
        ->join('messages', 'users.id', '=', 'messages.from')
        ->where('users.id', '!=', Auth::id())
        ->where('messages.to', '=', Auth::id())
        ->select('users.id', 'users.name', 'users.foto')
        ->distinct()->get()->toArray();

        $to = DB::table('users')
        ->join('messages', 'users.id', '=', 'messages.to')
        ->where('users.id', '!=', Auth::id())
        ->where('messages.from', '=', Auth::id())
        ->select('users.id', 'users.name', 'users.foto')
        ->distinct()->get()->toArray();
        
        $kontak = array_unique(array_merge($from, $to), SORT_REGULAR);
;
        if (empty($kontak)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data tidak tersedia',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data tersedia',
            'data' => $kontak
        ]);
    }

    public function pesan($id)
    {
        $pesan = Chat::where(function ($query) use ($id) {
            $query->where('from', Auth::id())->where('to', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('from', $id)->where('to', Auth::id());
        })->get();

        if (empty($pesan)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data tidak tersedia',
                'data' => null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'data tersedia',
                'data' => $pesan
            ]);
        }
    }

    public function kirim(Request $request, $id)
    {
        $pesan = Chat::create([
            'from' => Auth::id(),
            'to' => $id,
            'pesan' => $request->pesan,
            'status' => 0
        ]);

        if (empty($pesan)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data tidak tersedia',
                'data' => null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'data tersedia',
                'data' => $pesan
            ]);
        }
    }
}
