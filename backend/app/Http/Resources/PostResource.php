<?php

namespace App\Http\Resources;

use App\Models\Like;
use App\Models\Follow;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $has_follow = Follow::where(['followed' => $this->user_id, 'follower' => $request->user()->_id])->first() ? true : false;
        $has_liked = Like::where(['item_id' => $this->_id, 'user_id' => $request->user()->_id])->first() ? true : false;

        return [
            '_id' => $this->_id,
            'image'=> $this->image,
            'caption' => $this->caption,
            'likes' => $this->likes->count(),
            'comments' => CommentResource::collection($this->comments),
            'user' => new UserWithoutPostsResource($this->user),
            'has_followed' => $has_follow,
            'has_liked' => $has_liked,
            'own_post' => auth()->user()->_id == $this->user_id
        ];
    }
}
