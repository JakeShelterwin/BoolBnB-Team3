<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('location_messages', function (Blueprint $table) {
        $table-> foreign("location_id" , "locationM")
              -> references("id")
              -> on("locations")
              -> onDelete("cascade")
              ;
    });

    Schema::table('locations', function (Blueprint $table) {
        $table-> foreign("host_id" , "hostL")
              -> references("id")
              -> on("hosts")
              -> onDelete("cascade")
              ;
        $table-> foreign("sponsor_id" , "sponsorL")
              -> references("id")
              -> on("sponsors")
              -> onDelete("cascade")
              ;
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location_messages', function (Blueprint $table) {
            $table-> dropForeign("locationM");
        });
        Schema::table('locations', function (Blueprint $table) {
            $table-> dropForeign("hostL");
            $table-> dropForeign("sponsorL");
        });
    }
}
