<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
            'id'                => $this->id,
            'title'             => $this->title,
            'description'       => $this->description,
            'image'             => $this->image,
            'geo_search'        => $this->geo_search,
            'geo_dot'           => $this->geo_dot,
            'created_at'        => (string) $this->created_at,
            'updated_at'        => (string) $this->updated_at,
            'user'              => $this->user,
            'ratings'           => $this->ratings,
            'places_types_id'   => $this->places_types_id,
            'average_rating'    => $this->ratings->avg('rating')
        ];
    }
}
