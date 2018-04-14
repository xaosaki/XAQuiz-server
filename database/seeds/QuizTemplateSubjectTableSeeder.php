<?php

use Illuminate\Database\Seeder;

class QuizTemplateSubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quiz_template_subject')->insert([
            'quiz_template_id' => 1,
            'subject_id' => 1,
            'number_of_questions' => 1
        ]);
        DB::table('quiz_template_subject')->insert([
            'quiz_template_id' => 1,
            'subject_id' => 2,
            'number_of_questions' => 1
        ]);
    }
}
