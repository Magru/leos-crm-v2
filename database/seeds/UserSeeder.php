<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 2,
                'name' => 'מקסים פולקו',
                'email' => 'maxf@leos.co.il',
                'password' => Hash::make('yahmam1984fol')
            ],
        ]);
    }
}
