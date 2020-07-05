<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("address");
            $table->double("lat"); 
            $table->double("lon");
            $table->integer("rooms_n") -> unsigned();
            $table->integer("beds_n") -> unsigned();
            $table->integer("bathrooms_n") -> unsigned();
            $table->integer("square_meters") -> unsigned();
            $table->string("image");
            $table->boolean("is_active");
            $table->integer("sponsor_expire_time") -> nullable() -> unsigned();

            $table->bigInteger("user_id") -> unsigned() -> index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
