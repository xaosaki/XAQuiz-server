<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('answer_id');
            $table->unsignedInteger('quiz_question_id');

            $table->foreign('answer_id')->references('id')->on('answers');
            $table->foreign('quiz_question_id')->references('id')->on('quiz_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropForeign('quiz_answers_answer_id_foreign');
            $table->dropForeign('quiz_answers_quiz_question_id_foreign');
        });
        Schema::drop('quiz_answers');
    }
}
