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
        Schema::create('task', function (Blueprint $table) {
            $table->id('taskID');
            $table->unsignedBigInteger('timetableID')->nullable();
            $table->unsignedBigInteger('userID');
            $table->string('title');
            $table->double('priorityLevel');
            $table->string('description')->nullable();
            $table->boolean('status');
            $table->string('preferredTime')->nullable();
            $table->string('repeatOn')->nullable();
        });

        Schema::table('task', function (Blueprint $table) {
            $table->foreign('timetableID')->references('timetableID')->on('timetable');
            $table->foreign('userID')->references('userID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
};
