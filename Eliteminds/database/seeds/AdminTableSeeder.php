<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create the admin user Account ..
        DB::table('admins')->insert([
            'name'=>'Mohamed Ahmed',
            'email'=>'admin@me.com',
            'password'=>bcrypt('admin111'),
        ]);
    }
}
