<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingResource;
use App\Models\Place;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    //
    public function store(Request $request, Place $place)
    {
        $rating = Rating::firstOrCreate(
            [
                'user_id'  => $request->user()->id,
                'place_id' => $place->id,
            ],
            ['rating' => $request->rating]
        );

        return new RatingResource($rating);
    }
}
