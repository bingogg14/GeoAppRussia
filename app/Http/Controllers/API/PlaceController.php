<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return PlaceResource::collection(Place::with('ratings')->paginate(25));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $place = Place::create([
            'user_id'         => $request->user()->id,
            'title'           => $request->title,
            'description'     => $request->description,
            'image'           => $request->image,
            'geo_search'      => $request->geo_search,
            'geo_dot'         => $request->geo_dot,
            'places_types_id' => $request->places_types_id,
        ]);

        return new PlaceResource($place);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        return new PlaceResource($place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        // check if currently authenticated user is the owner of the book
        if ($request->user()->id !== $place->user_id) {
            return response()->json(['error' => 'You can only edit your own books.'], 403);
        }

        $place->update($request->only(
            [
                'title',
                'description',
                'image',
                'geo_search',
                'geo_dot',
                'places_types_id'
            ])
        );

        return new PlaceResource($place);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
        $place->delete();

        return response()->json(null, 204);
    }
}
