<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('admin.index', [
            'page' => $this->page
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
