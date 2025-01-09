<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
           ['category_name' => 'HTML'],
           ['category_name' => 'CSS'],
           ['category_name' => 'JavaScript'],
           ['category_name' => 'PHP'],
           ['category_name' => 'MYSQL'],
        ]);
    }
}
