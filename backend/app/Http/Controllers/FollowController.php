<?php

namespace App\Http\Controllers;

use App\Http\Requests\FollowRequest;
use App\Models\Follow;
use App\Models\User;

class FollowController extends Controller
{
    /**
     * Register new follow or remove.
     *
     * @param  \Illuminate\Http\FollowRequest  $request
     * @return Response
     */
    public function doFollow(FollowRequest $request)
    {
        $check = Follow::where(['follower' => $request->user()->_id, 'followed' => $request->followed]);

        if ($check->first()) {

            $check->delete();

            return response()->json("unfollowed");
        }

        Follow::create([
            'follower' => $request->user()->_id,
            'followed' => $request->followed,
            'status' => "done"
        ]);

        return response()->json("followed");
    }

    /**
     * Check if the user has follow an other user.
     *
     * @param  \Illuminate\Http\FollowRequest  $request
     * @return Boolean
     */
    public function haveFollow(Request $request)
    {
        $user_id = User::where('username', $request->followed)->first()->_id;

        $check = Follow::where(['follower' => $request->user()->_id, 'followed' => $user_id])->first();

        if ($check) {
            return response()->json(true);
        }

        return response()->json(false);
    }
}
