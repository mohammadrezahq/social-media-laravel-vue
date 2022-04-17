<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserWithoutPostsResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Returns user profile.
     *
     * @param  Request  $request
     * @return UserResource $user
     */
    public function show(Request $request)
    {
        $user = User::with(['posts', 'followings', 'followers'])
                ->where('username', $request->username)
                ->first();

        return response()->json(new UserResource($user));
    }

    /**
     * Search in users with their username or display_name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserWithoutPostsResource $users
     */
    public function search(Request $request)
    {
        $request->validate([
            'username' => 'string'
        ]);

        $users = User::select(['avatar', 'username', 'display_name'])
                ->where('username', 'like', '%' .  $request->username  . '%')
                ->orWhere('display_name', 'like', '%' .  $request->username  . '%')
                ->limit(5)
                ->get();

        return response()->json(UserWithoutPostsResource::collection($users));
    }

    /**
     * Update the user.
     *
     * @param  UserUpdateRequest  $request
     * @return Boolean
     */
    public function update(UserUpdateRequest $request)
    {
        $user = User::where('_id', Auth::id());

        if ($request->avatar) {

            $file_name = time().'_'.$request->avatar->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME);

            $file_path = Storage::disk('uploads')->put('avatars/' . $file_name, $request->file('avatar'));
            $url = url('/i') . '/' . $file_path;
            $user->update(['avatar' => $url]);

            return response()->json($url);

        }

        $update = $user->update($request->all());

        return response()->json($update);
    }

    /**
     * Change user's password.
     *
     * @param  ChangePasswordRequest  $request
     * @return Boolean
     */
    public function password(ChangePasswordRequest $request)
    {
        $user = User::find($request->user()->_id)->update([
            'password' => $request->password
        ]);

        return response()->json($user);
    }

    /**
     * Log out the user.
     *
     * @param  Request  $request
     * @return Boolean
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json(1);
    }

    /**
     * Delete the user.
     *
     * @param  Request  $request
     * @return Boolean
     */
    public function delete(Request $request)
    {
        $user = User::find($request->user()->_id)->first();

        if ($user) {

            $user->delete();

            auth()->user()->tokens()->delete();

            return response()->json(1);

        }

        return response()->json(0, 404);
    }
}
