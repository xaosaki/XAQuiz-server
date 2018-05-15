<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'text' => 'Выберите теги заголовков:',
            'type' => 'checkbox',
            'subject_id' => 1,
            'correct_answers' => 2
        ]);
        DB::table('questions')->insert([
            'text' => 'Какое свойство отвечает за внутренние отступы?',
            'type' => 'radio',
            'subject_id' => 2,
            'correct_answers' => 1
        ]);
        DB::table('questions')->insert([
            'text' => 'Какое свойство отвечает за внешние отступы?',
            'type' => 'radio',
            'subject_id' => 2,
            'correct_answers' => 1
        ]);
    }
}
