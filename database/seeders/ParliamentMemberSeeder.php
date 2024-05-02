<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParliamentMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parliament_members')->insert([
            'first_name' => 'John',
            'last_name' => 'Smith',
            'party' => 'Partij van de Ruimte en Tijd',
        ]);
    }
}
