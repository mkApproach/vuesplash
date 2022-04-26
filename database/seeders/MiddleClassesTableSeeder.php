<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MiddleClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'major_id' => 'mens',
            'middle_id' => 'uniform',
            'name' => 'ユニフォーム',
        ];
        DB::table('middleclasses')->insert($param);

        $param = [
            'major_id' => 'mens',
            'middle_id' => 'socks',
            'name' => 'ソックス',
        ];
        DB::table('middleclasses')->insert($param);

        $param = [
            'major_id' => 'mens',
            'middle_id' => 'pants',
            'name' => 'パンツ',
        ];
        DB::table('middleclasses')->insert($param);

       //
        $param = [
            'major_id' => 'ladies',
            'middle_id' => 'uniform',
            'name' => 'ユニフォーム',
        ];
        DB::table('middleclasses')->insert($param);

        $param = [
            'major_id' => 'ladies',
            'middle_id' => 'socks',
            'name' => 'ソックス',
        ];
        DB::table('middleclasses')->insert($param);

        $param = [
            'major_id' => 'ladies',
            'middle_id' => 'pants',
            'name' => 'パンツ',
        ];
        DB::table('middleclasses')->insert($param);


        //
        $param = [
            'major_id' => 'kids',
            'middle_id' => 'uniform',
            'name' => 'ユニフォーム',
        ];
        DB::table('middleclasses')->insert($param);

        $param = [
            'major_id' => 'kids',
            'middle_id' => 'socks',
            'name' => 'ソックス',
        ];
        DB::table('middleclasses')->insert($param);

        $param = [
            'major_id' => 'kids',
            'middle_id' => 'pants',
            'name' => 'パンツ',
        ];
        DB::table('middleclasses')->insert($param);
    }
}
