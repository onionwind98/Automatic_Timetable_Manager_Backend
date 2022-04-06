<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_timeslot', function (Blueprint $table) {
            $table->primary(['taskID','timeslotID']);
            $table->unsignedBigInteger('taskID');
            $table->unsignedBigInteger('timeslotID');
        });

        Schema::table('task_timeslot', function (Blueprint $table) {
            $table->foreign('taskID')->references('taskID')->on('task');
            $table->foreign('timeslotID')->references('timeslotID')->on('timeslot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_timeslot');
    }
};
