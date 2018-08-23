<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
        $validation = self::required($request);
        if ($validation->fails()) {
            return response()->json(['success'=> false, 'error'=> $validation->messages()]);
        } else {
            $place = new Place();
            $place = self::fields($place, $request);
            return new PlaceResource($place);
        }
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

        $validation = self::required($request);
        if ($validation->fails()) {
            return response()->json(['success'=> false, 'error'=> $validation->messages()]);
        } else {
            $place = self::fields($place, $request);
            return new PlaceResource($place);
        }

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

    //Filling Model
    public function fields($object, Request $request) {
        $data                       = $request->all();
        $object->user_id            = $request->user()->id;
        $object->title              = $data['title'];
        $object->description        = $data['description'];
        $object->image              = $data['image'];
        $object->geo_search         = $data['geo_search'];
        $object->geo_dot            = $data['geo_dot'];
        $object->places_types_id    = $data['places_types_id'];
        $object->save();
        return $object;
    }
    //Validate Form
    public function required(Request $request) {
        $rules = array(
            'title'                    => 'required|string|min:3|max:255',
            'description'              => "required|string|min:3|max:255",
            'image'                    => "required|string|min:3|max:255",
            'geo_search'               => "required|string|min:3|max:255",
            'geo_dot'                  => "required|string|min:3|max:255",
            'places_types_id'          => "required|exists:places_types,id",
        );
        return  $validator = Validator::make($request->all(), $rules);
    }
}
