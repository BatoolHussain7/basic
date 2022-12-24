<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('consultations')->insert([
            [
                'name'=>'Medical'
            ],
            [
                'name'=>'Professional'
            ],
            [
                'name'=>'Psychological'
            ],
            [
                'name'=>'Family'
            ],
            [
                'name'=>'Business'
            ],
        ]);    
    }
}
