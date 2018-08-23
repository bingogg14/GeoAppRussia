<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places_filters', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('filter_type_id');
            $table->string('title');
            $table->string('question');
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
            Schema::dropIfExists('places_filters');
    }
}
