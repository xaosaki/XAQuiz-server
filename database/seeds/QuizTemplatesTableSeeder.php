<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quiz_templates')->insert([
            'name' => 'HTML + CSS (2 вопроса)'
        ]);
    }
}
