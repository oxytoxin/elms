<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('grading_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained();
            $table->integer('attendance_weight')->default(5);
            $table->integer('assignment_weight')->default(15);
            $table->integer('quiz_weight')->default(15);
            $table->integer('activity_weight')->default(15);
            $table->integer('exam_weight')->default(50);
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
        Schema::dropIfExists('grading_systems');
    }
}