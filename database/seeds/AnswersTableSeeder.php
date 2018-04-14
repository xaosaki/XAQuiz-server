<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $text = ['<h1>','<h2>','<br>','margin','padding','border'];
        $question_id = [1,1,1,2,2,2];
        $is_correct = [true,true,false,false,true,false];
        for ($i = 0; $i < 6; $i++){
            DB::table('answers')->insert([
                'text' => $text[$i],
                'question_id' => $question_id[$i],
                'is_correct' => $is_correct[$i]
            ]);
        }
    }
}
