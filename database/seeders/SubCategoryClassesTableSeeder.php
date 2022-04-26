<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoryClassesTableSeeder extends Seeder
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
            'subcategory_id' => 'futsal',
            'name' => 'フットサル',
        ];
        DB::table('subcategoryclasses')->insert($param);

        $param = [
            'major_id' => 'mens',
            'middle_id' => 'socks',
            'subcategory_id' => 'soccer',
            'name' => 'サッカー',
        ];
        DB::table('subcategoryclasses')->insert($param);

        $param = [
            'major_id' => 'mens',
            'middle_id' => 'pants',
            'subcategory_id' => 'baseball',
            'name' => '野　球',
        ];
        DB::table('subcategoryclasses')->insert($param);

       //
        $param = [
            'major_id' => 'ladies',
            'middle_id' => 'uniform',
            'subcategory_id' => 'futsal',
            'name' => 'フットサル',
           ];
        DB::table('subcategoryclasses')->insert($param);

        $param = [
            'major_id' => 'ladies',
            'middle_id' => 'socks',
            'subcategory_id' => 'soccer',
            'name' => 'サッカー',
        ];
        DB::table('subcategoryclasses')->insert($param);

        $param = [
            'major_id' => 'ladies',
            'middle_id' => 'pants',
            'subcategory_id' => 'baseball',
            'name' => '野　球',
        ];
        DB::table('subcategoryclasses')->insert($param);


        //
        $param = [
            'major_id' => 'kids',
            'middle_id' => 'uniform',
            'subcategory_id' => 'futsal',
            'name' => 'フットサル',
           ];
        DB::table('subcategoryclasses')->insert($param);

        $param = [
            'major_id' => 'kids',
            'middle_id' => 'socks',
            'subcategory_id' => 'soccer',
            'name' => 'サッカー',
        ];
        DB::table('subcategoryclasses')->insert($param);

        $param = [
            'major_id' => 'kids',
            'middle_id' => 'pants',
            'subcategory_id' => 'baseball',
            'name' => '野　球',
        ];
        DB::table('subcategoryclasses')->insert($param);

    }
}
