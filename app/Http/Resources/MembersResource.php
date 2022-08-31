<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MembersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $item['name'] = $this->name;
        $item['email'] = $this->email;

        if (!$this->parent_id) {
            $item['photo'] = photoToMedia($this->photo);
            $item['title'] = $this->role;
        } else {
            $item['role'] = $this->role;
        }

        if (count($this->children)) {
            $item['children'] = MembersResource::collection($this->children);
        }

        return $item;
    }
}
