<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drafts', function (Blueprint $table) {
            $table->id();
            $table->date('date_due');
            $table->time('time_due');
            $table->date('date_open')->nullable()->default(null);
            $table->time('time_open')->nullable()->default(null);
            $table->foreignId('module_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->json('items');
            $table->json('task_rubric');
            $table->json('rubric');
            $table->json('matchingTypeOptions');
            $table->string('type');
            $table->string('task_name')->nullable()->default(null);
            $table->mediumText('task_instructions')->nullable()->default(null);
            $table->boolean('allSection');
            $table->boolean('noDeadline');
            $table->boolean('openImmediately');
            $table->boolean('isRubricSet');
            $table->integer('total_points');
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
        Schema::dropIfExists('drafts');
    }
}
