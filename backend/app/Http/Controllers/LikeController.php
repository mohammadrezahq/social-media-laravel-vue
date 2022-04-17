<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Handle like.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Boolean
     */
    public function doLike(Request $request)
    {
        $user_id = $request->user()->_id;
        $item_id = $request->id;

        $query = Like::where('user_id', $user_id)->where('item_id', $item_id);

        if (!empty($query->first())) {

            return response()->json($query->delete());

        }

        $like = new Like();
        $like->kind = 'post';
        $like->user_id = $user_id;
        $like->item_id = $item_id;
        $like->save();

        if ($like) {

            return response()->json(true);

        }
    }

}
