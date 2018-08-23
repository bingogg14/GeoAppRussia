<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id'    => $this->user_id,
            'place_id'   => $this->place_id,
            'rating'     => $this->rating,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'place'       => $this->place,
        ];
    }
}
