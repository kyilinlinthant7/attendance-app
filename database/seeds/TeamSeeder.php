<?php

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            'name'=>'',
            'team_id'=>'',
            'manager_id'=>'',
            'leader_id'=>'',
            'member_id'=>''
        ]);
    }
}
