<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'geo_search',
        'geo_dot',
        'places_types_id',
    ];

//    protected $attributes = [
//        'places_type'
//    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

//    //Atributes
//    public function getPlacesTypeAttribute() {
//        return $this->hasOne('places_types', 'id', 'places_types_id');
//    }
}
