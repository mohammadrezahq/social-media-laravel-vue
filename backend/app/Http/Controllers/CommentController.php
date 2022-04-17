<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Get comments of the post.
     *
     * @param Request $request
     * @return Json $comments
     */
    public function get(Request $request)
    {
        $comments = Comment::where('item_id', $request->post_id)->get();

        return response()->json(CommentResource::collection($comments));
    }

    /**
     * Store a comment for the post.
     *
     * @param CommentRequest $request
     * @return Json $comment
     */
    public function store(CommentRequest $request)
    {
        $user_id = $request->user()->_id;
        $post_id = $request->post_id;

        $comment = new Comment();
        $comment->post_id = $post_id;
        $comment->user_id = $user_id;
        $comment->reply_to = null;
        $comment->text = $request->comment;
        $comment->save();

        return response()->json(new CommentResource($comment));
    }

}
