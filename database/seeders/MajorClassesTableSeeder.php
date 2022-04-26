<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorClassesTableSeeder extends Seeder
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
            'name' => 'メンズ',
        ];
        DB::table('majorclasses')->insert($param);

        $param = [
            'major_id' => 'ladies',
            'name' => 'レディース',
        ];
        DB::table('majorclasses')->insert($param);

        $param = [
            'major_id' => 'kids',
            'name' => 'キッズ',
        ];
        DB::table('majorclasses')->insert($param);

        $param = [
            'major_id' => 'unisex',
            'name' => 'ユニセックス',
        ];
        DB::table('majorclasses')->insert($param);

        $param = [
            'major_id' => 'hygiene',
            'name' => '衛生品',
        ];
        DB::table('majorclasses')->insert($param);

        $param = [
            'major_id' => 'daily',
            'name' => '日用品',
        ];
        DB::table('majorclasses')->insert($param);

        $param = [
            'major_id' => 'other',
            'name' => 'その他',
        ];
        DB::table('majorclasses')->insert($param);


    }
}
