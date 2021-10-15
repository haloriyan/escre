<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('connect_id')->unsigned()->index();
            $table->foreign('connect_id')->references('id')->on('connects')->onDelete('cascade');
            $table->string('title');
            $table->datetime('date');
            $table->integer('duration');
            $table->string('place');
            $table->string('place_type');
            $table->text('notes')->nullable();
            $table->string('status');
            $table->tinyInteger('status_code');
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
        Schema::dropIfExists('schedules');
    }
}
