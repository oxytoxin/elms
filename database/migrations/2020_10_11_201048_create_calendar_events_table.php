<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('code');
            $table->string('level');
            $table->foreignId('section_id')->nullable()->default(null)->constrained();
            $table->string('title');
            $table->boolean('allDay')->default(true);
            $table->string('description');
            $table->string('classNames')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
            $table->string('start');
            $table->string('end')->nullable()->default(null);
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
        Schema::dropIfExists('calendar_events');
    }
}