<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect()->back()->with('message', 'Berhasil Dihapus');
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255|min:8|confirmed',
            'telpon' => 'required|string|unique:users',
            'alamat' => 'required|string',
            'foto' => 'mimes:jpeg,bmp,png,gif,jpg',
            'role' => 'required|integer',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->telpon = $request->telpon;
        $user->alamat = $request->alamat;

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $file = base64_encode(file_get_contents($image));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $file,
                    'format' => 'json'
                ]
            ]);

            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            $image = $data->image->url;

            $user->foto = $image;
        }

        $user->role = $request->role;

        try {
            $user->save();
            
            return redirect()->back()->with('message', 'User Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit' , [
            'page' => $this->page,
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'password' => 'confirmed',
            'foto' => 'mimes:jpeg,bmp,png,gif,jpg',
            'email' => 'unique:users,email,'.$user->id,
            'telpon' => 'unique:users,telpon,'.$user->id
        ]);

        $data = $request->except(['foto']);

        $result = array_filter($data);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $file = base64_encode(file_get_contents($image));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $file,
                    'format' => 'json'
                ]
            ]);

            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            $image = $data->image->url;

            $user->foto = $image;
        }

        try {
            $user->update($result);
            
            if ($request->who == 'admin') {
                return redirect()->back()->with('message', 'User Berhasil Diupdate');
            }
            return redirect(route('user.index'))->with('message', 'User Berhasil Diupdate');
        } catch (\Throwable $th) {
            return redirect(route('user.index'))->withErrors($th->getMessage());
        }
    }
}
