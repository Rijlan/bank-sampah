<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiNasabahChatController extends Controller
{
    public function kontak()
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
