<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNameResource extends JsonResource
{
    public function toArray($request)
    {
        return $data = [
            'id'=> $this->id,
            'username'=> $this->username,

        ];
    }
}
