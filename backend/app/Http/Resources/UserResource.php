<?php

namespace App\Http\Resources;

use App\Models\Follow;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            '_id' => $this->_id,
            'username' => $this->username,
            'display_name'=> $this->display_name,
            'avatar' => $this->avatar,
            'bio'  => $this->bio,
            'posts' => PostWithoutUserResource::collection($this->posts),
            'followings' => $this->followings->count(),
            'followers' => $this->followers->count(),
            'has_follow' => Follow::where(['follower' => $request->user()->_id, 'followed' => $this->_id])->first() ? true : false
        ];
    }
}
