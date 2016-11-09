<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaraTokSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laratok_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('session_name');
            $table->longText('session_id');
            $table->string('media_mode');
            $table->string('archive_mode');
            $table->ipAddress('location')->nullable();
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
        Schema::dropIfExists('laratok_sessions');
    }
}
