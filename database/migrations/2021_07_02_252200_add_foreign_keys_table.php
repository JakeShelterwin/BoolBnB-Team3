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
      Schema::table('messages', function (Blueprint $table) {
        $table-> foreign("apartment_id" , "apartmentM")
              -> references("id")
              -> on("apartments")
              -> onDelete("cascade")
              ;
    });

    Schema::table('apartments', function (Blueprint $table) {
        $table-> foreign("user_id" , "userL")
              -> references("id")
              -> on("users")
              -> onDelete("cascade")
              ;
    });

    Schema::table('apartment_service', function (Blueprint $table) {
        $table-> foreign("apartment_id" , "apartmentS")
              -> references("id")
              -> on("apartments")
              -> onDelete("cascade")
              ;
        $table-> foreign("service_id" , "serviceS")
              -> references("id")
              -> on("services")
              -> onDelete("cascade")
              ;
    });

      Schema::table('apartment_sponsor', function (Blueprint $table) {
          $table-> foreign("apartment_id" , "apartmentA")
                -> references("id")
                -> on("apartments")
                -> onDelete("cascade")
                ;
          $table-> foreign("sponsor_id" , "sponsorA")
                -> references("id")
                -> on("sponsors")
                -> onDelete("cascade")
                ;
      });
      Schema::table('views', function (Blueprint $table) {
        $table-> foreign("apartment_id" , "apartmentV")
              -> references("id")
              -> on("apartments")
              -> onDelete("cascade")
              ;
        $table-> foreign("user_id" , "userV")
              -> references("id")
              -> on("users")
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
        Schema::table('messages', function (Blueprint $table) {
            $table-> dropForeign("apartmentM");
        });
        Schema::table('apartments', function (Blueprint $table) {
            $table-> dropForeign("userL");
        });
        Schema::table('apartment_service', function (Blueprint $table) {
            $table-> dropForeign("apartmentS");
            $table-> dropForeign("serviceS");
        });
        Schema::table('apartment_sponsor', function (Blueprint $table) {
            $table-> dropForeign("apartmentA");
            $table-> dropForeign("sponsorA");
        });
        Schema::table('views', function (Blueprint $table) {
            $table-> dropForeign("apartmentV");
            // $table-> dropForeign("userV");
        });
    }
}
