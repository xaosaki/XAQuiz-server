<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizTemplateSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_template_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quiz_template_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('number_of_questions');

            $table->foreign('quiz_template_id')->references('id')->on('quiz_templates');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_template_subject');
    }
}
