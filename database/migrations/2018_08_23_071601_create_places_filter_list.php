<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesFilterList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places_filters_list', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->unsignedInteger('place_id');
            $table->unsignedInteger('places_filters_types_id');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            //
            Schema::dropIfExists('places_filters_types');
    }
}
