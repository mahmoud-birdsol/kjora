<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'parent' => MessageResource::make($this->resource->parentMessage),
            'parent_id' => $this->parent_id,
            'sender_id' => $this->sender_id,
            'media' => $this->resource->getFirstMedia('attachments')
        ];
    }
}
