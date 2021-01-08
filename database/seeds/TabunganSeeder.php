<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TabunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabungan = [
            [
                'user_id' => 7,                
                'debit' => 12500,
                'kredit' => 0,
            ],
            [
                'user_id' => 7,                
                'debit' => 4800,
                'kredit' => 0,
            ],
            [
                'user_id' => 7,                
                'debit' => 0,
                'kredit' => 5000,
            ],
            [
                'user_id' => 7,                
                'debit' => 12000,
                'kredit' => 0,
            ],
            [
                'user_id' => 7,                
                'debit' => 4000,
                'kredit' => 0,
            ],
            [
                'user_id' => 7,                
                'debit' => 0,
                'kredit' => 7000,
            ]
        ];

        DB::table('tabungans')->insert($tabungan);
    }
}
