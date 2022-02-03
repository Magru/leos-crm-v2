<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MondaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('monday_departments')->insert([
            'title' => 'מחלקת פיתוח',
            'monday_id' => '247509',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מתל',
            'monday_id' => '247510',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מחלקת עיצוב',
            'monday_id' => '247511',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מחלקת קידום אורגני',
            'monday_id' => '247513',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מחלקת פרסום בגוגל',
            'monday_id' => '247514',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מחלקת פרסום בפייסבוק',
            'monday_id' => '247515',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מחלקת פרסום',
            'monday_id' => '247516',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מחלקת כתיבת תוכן',
            'monday_id' => '247517',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מחלקת הזנת תכנים',
            'monday_id' => '247518',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'הנהלה',
            'monday_id' => '261203',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'מחלקת שיווק',
            'monday_id' => '295017',
            'monday_type' => 'team',
        ]);

        DB::table('monday_departments')->insert([
            'title' => 'תוכן',
            'monday_id' => '297749',
            'monday_type' => 'team',
        ]);
    }
}
