<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Login the user.
     *
     * @param LoginRequest $request
     * @return Json $data = ['user', 'token']
     */
    public function login(LoginRequest $request)
    {
        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {

            $check = Auth::attempt(['email' => $request->username, 'password' => $request->password]);

        } else {

            $check = Auth::attempt(['username' => $request->username, 'password' => $request->password]);

        }

        if ($check) {

            $auth = Auth::user();
            $token = $auth->createToken('LaravelSanctumAuth')->plainTextToken;

            $data = ['user' => $auth, 'token' => $token];

            return response()->json($data);

        } else {

            $data = 'Username/Email or Password is not correct.';

            return response()->json($data, 404);
        }
    }

    /**
     * Register the user.
     *
     * @param RegisterRequest $request
     * @return Json $data = ['user', 'token']
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();

        if ($request->avatar) {
            $file_name = time() . '_' . $request->avatar->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME);

            $file_path = Storage::disk('uploads')->put('avatars/' . $file_name, $request->file('avatar'));
            $user->avatar = url('/i') . '/' . $file_path;
        }

        $user->username = $request->username;
        $user->email = $request->email;
        $user->display_name = $request->display_name;
        $user->password = $request->password;
        $user->bio = $request->bio;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->save();

        $auth = Auth::login($user);
        $auth = Auth::user();
        $token = $auth->createToken('LaravelSanctumAuth')->plainTextToken;

        $data = ['user' => $auth, 'token' => $token];

        return response()->json($data, 201);
    }
}
