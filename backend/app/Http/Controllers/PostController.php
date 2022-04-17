<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostWithoutUserResource;
use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Return the explore posts.
     *
     * @param Request $request
     * @return PostResource $post
     */
    public function show(Request $request)
    {
        $post = Post::with(['comments.user', 'likes', 'user'])
            ->where('_id', $request->_id)->first();

        return response()->json(new PostResource($post));
    }

    /**
     * Return the explore posts.
     *
     * @return Json $posts
     */
    public function explorePosts()
    {
        $posts = Post::where('user', '!=', auth()->user()->_id)
            ->get()->random(40);

        return response()->json(PostWithoutUserResource::collection($posts));
    }

    /**
     * Display the feed posts.
     *
     * @return Json $posts
     */
    public function getFeed()
    {
        $user_followings = Follow::where('follower', auth()->user()->_id)
            ->get()->pluck('followed');

        $posts = Post::whereIn('user_id', $user_followings)
            ->orderBy('created_at', 'DESC')->get();

        return response()->json(PostWithoutUserResource::collection($posts));
    }

    /**
     * Create a new post.
     *
     * @param PostRequest $request
     * @return Json $post
     */
    public function store(PostRequest $request)
    {
        $file_name = time() . '_' . $request->avatar->getClientOriginalName();
        $file_name = pathinfo($file_name, PATHINFO_FILENAME);

        $file_path = Storage::disk('uploads')
                    ->put('posts/' . $file_name, $request->file('avatar'));

        $url = url('/i') . '/' . $file_path;

        $post = new Post();
        $post->user_id = $request->user()->_id;
        $post->image = $url;
        $post->caption = $request->caption;
        $post->save();

        return response()->json($post);
    }

    /**
     * Update the post.
     *
     * @param  Request  $request
     * @return Boolean
     */
    public function update(Request $request)
    {
        $post_id = $request->post_id;
        $caption = $request->caption;

        $post = Post::where('_id', $post_id);

        if ($post->first()->user_id == $request->user()->_id) {

            return response()->json($post->update(['caption' => $caption]));
        }

        return response()->json('No Access', 404);
    }

    /**
     * Delete the post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Boolean
     */
    public function delete(Request $request)
    {
        $id = $request->post_id;

        $post = Post::where('_id', $id);

        if ($post->first()->user_id == $request->user()->_id) {

            return response()->json($post->delete());
        }

        return response()->json('No Access.', 403);
    }
}
