<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(JenisBarangSeeder::class);
        $this->call(CatatanSeeder::class);
        $this->call(PenjemputanSeeder::class);
        $this->call(PenjualanSeeder::class);
        $this->call(TabunganSeeder::class);
    }
}
