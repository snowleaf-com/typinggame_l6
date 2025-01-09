<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class DrillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drills')->insert([
           [
           'user_id' => 1,
           'category_id' => 1,
           'title' => 'ゴ〜ゴータイプゲーム',
            'high_score' => 100,
            'high_score_user_id' => 2,
            'difficulty' => 4,
           ],
            [
           'user_id' => 2,
           'category_id' => 3,
           'title' => '最強への道',
            'high_score' => 200,
            'high_score_user_id' => 3,
            'difficulty' => 2,
           ],
            [
           'user_id' => 3,
           'category_id' => 4,
           'title' => 'バリバリ伝説',
            'high_score' => 300,
            'high_score_user_id' => 1,
            'difficulty' => 1,
           ],

        ]);
    }
}
