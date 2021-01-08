<?php


namespace App\Http\Controllers;

use App\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiUserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = User::where('email', $request->email)->first();
        return response()->json(compact('token', 'user'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'telpon' => 'required|unique:users',
            'alamat' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $foto = null;

        if ($request->foto) {
            $img = base64_encode(file_get_contents($request->foto));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $img,
                    'format' => 'json',
                ]
            ]);
            $array = json_decode($res->getBody()->getContents());
            $foto = $array->image->file->resource->chain->image;
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'telpon' => $request->telpon,
            'alamat' => $request->alamat,
            'role' => 3,
            'foto' => $foto,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    public function editProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }


        $foto = null;

        if ($request->foto) {
            $img = base64_encode(file_get_contents($request->foto));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $img,
                    'format' => 'json',
                ]
            ]);
            $array = json_decode($res->getBody()->getContents());
            $foto = $array->image->file->resource->chain->image;
        }


        $user = User::find(Auth::id())->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'foto' => $foto,
        ]);

        if (empty($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data gagal diupdate',
                'data' => null,
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil diupdate',
            'data' => $user,
        ]);
    }

    public function editTelpon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'telpon' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::find(Auth::id())->update([
            'telpon' => $request->telpon
        ]);

        if (empty($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data gagal diupdate',
                'data' => null,
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil diupdate',
            'data' => $user,
        ]);
    }

    public function editPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::find(Auth::id());

        if (Hash::check($request->password_lama, $user->password)) {
            $user->password = Hash::make($request->password);

            try {
                $user->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'data berhasil diupdate',
                    'data' => $user,
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'data gagal diupdate',
                    'data' => null,
                ]);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'password lama yang anda masukkan salah',
                'data' => null,
            ]);
        }
    }
}

//
//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//
//class UserController extends Controller
//{
//    //
//}
