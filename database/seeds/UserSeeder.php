<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('user')->insert([
            'username' => 'admin2',
            'password' => bcrypt('12345'),
        ]);
        \DB::table('user')->insert([
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        for($i=0;$i<50;$i++){
            $faker = \Faker\Factory::create();
            DB::table('jenis_laporan')->insert([
                'kode'=>str_random(5),
                'deskripsi'=>$faker->text
            ]);
        }
    }
}
