<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class ProblemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('problems')->insert([
           [
               'drill_id' => 1,
               'question' => 'testtttttttest',
               'order' => 1,
           ],
            [
               'drill_id' => 1,
               'question' => 'testtttttttest2',
               'order' => 2,
           ],
            [
               'drill_id' => 1,
               'question' => 'testtttttttes3t3',
               'order' => 3,
           ],
            [
               'drill_id' => 1,
               'question' => 'testtttttttes4',
               'order' => 4,
           ],
            [
               'drill_id' => 1,
               'question' => 'testtttttttes5',
               'order' => 5,
           ],
            [
                'drill_id' => 1,
                'question' => 'testtttttttest',
                'order' => 6,
            ],
            [
                'drill_id' => 1,
                'question' => 'testtttttttest2',
                'order' => 7,
            ],
            [
                'drill_id' => 1,
                'question' => 'testtttttttes3t3',
                'order' => 8,
            ],
            [
                'drill_id' => 1,
                'question' => 'testtttttttes4',
                'order' => 9,
            ],
            [
                'drill_id' => 1,
                'question' => 'testtttttttes5',
                'order' => 10,
            ],
            [
               'drill_id' => 2,
               'question' => 'testtttttttest',
               'order' => 1,
           ],
            [
               'drill_id' => 2,
               'question' => 'testtttttttest2',
               'order' => 2,
           ],
            [
               'drill_id' => 2,
               'question' => 'testtttttttes3t3',
               'order' => 3,
           ],
            [
               'drill_id' => 2,
               'question' => 'testtttttttes4',
               'order' => 4,
           ],
            [
               'drill_id' => 2,
               'question' => 'testtttttttes5',
               'order' => 5,
           ],
            [
                'drill_id' => 2,
                'question' => 'testtttttttest',
                'order' => 6,
            ],
            [
                'drill_id' => 2,
                'question' => 'testtttttttest2',
                'order' => 7,
            ],
            [
                'drill_id' => 2,
                'question' => 'testtttttttes3t3',
                'order' => 8,
            ],
            [
                'drill_id' => 2,
                'question' => 'testtttttttes4',
                'order' => 9,
            ],
            [
                'drill_id' => 2,
                'question' => 'testtttttttes5',
                'order' => 10,
            ],
            [
               'drill_id' => 3,
               'question' => 'testtttttttest',
               'order' => 1,
           ],
            [
               'drill_id' => 3,
               'question' => 'testtttttttest2',
               'order' => 2,
           ],
            [
               'drill_id' => 3,
               'question' => 'testtttttttes3t3',
               'order' => 3,
           ],
            [
               'drill_id' => 3,
               'question' => 'testtttttttes4',
               'order' => 4,
           ],
            [
               'drill_id' => 3,
               'question' => 'testtttttttes5',
               'order' => 5,
           ],
            [
                'drill_id' => 3,
                'question' => 'testtttttttest',
                'order' => 6,
            ],
            [
                'drill_id' => 3,
                'question' => 'testtttttttest2',
                'order' => 7,
            ],
            [
                'drill_id' => 3,
                'question' => 'testtttttttes3t3',
                'order' => 8,
            ],
            [
                'drill_id' => 3,
                'question' => 'testtttttttes4',
                'order' => 9,
            ],
            [
                'drill_id' => 3,
                'question' => 'testtttttttes5',
                'order' => 10,
            ],
        ]);
    }
}
