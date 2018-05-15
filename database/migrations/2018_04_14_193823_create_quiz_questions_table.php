<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('quiz_id');
            $table->unsignedInteger('question_id');
            $table->boolean('is_completed');

            $table->foreign('quiz_id')->references('id')->on('quizzes');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropForeign('quiz_questions_question_id_foreign');
            $table->dropForeign('quiz_questions_quiz_id_foreign');
        });
        Schema::dropIfExists('quiz_questions');
    }
}
