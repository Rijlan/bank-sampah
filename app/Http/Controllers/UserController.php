<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->page = [
            'active' => 'user'
        ];
    }
    
    public function index() {
        $users = User::where('role', '!=', 3)->where('role', '!=', 5)->orderBy('role', 'DESC')->get();
        
        return view('user.index' , [
            'page' => $this->page,
            'users' => $users
        ]);
    }
    
    public function destroy($id) {
        $user = User::findOrFail($id);

        try {
            $user->delete();
        } catch (\Throwable $th) {
            return redirect(route('user.index'));
        }

        return redirect(route('user.index'));
    }
}
