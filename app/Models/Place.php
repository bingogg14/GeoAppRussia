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
        'type_place_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
