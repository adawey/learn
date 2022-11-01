<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(
        //     UsersTableSeeder::class
        //     AdminTableSeeder::class
        // );
        $faker = Faker\Factory::create();
        // users Table ..
        /*
        for ($i=0; $i < 4; $i++) { 
            App\User::create([
                'name'=> $faker->name,
                'email'=>$faker->unique()->email,
                'password' => bcrypt('test'),
                'remember_token' => str_random(10),
            ]);
        }
         */

         // questions Table ..
         /*
        for ($i=0; $i < 20; $i++) { 
            App\Question::create([
                'title'=>$faker->text,
                'a' => str_random(10),
                'b' => str_random(10),
                'c' => str_random(10),
                'correct_answer'=> str_random(10),
                'chapter'=> '2',
                'process_group'=>'3',
                'feedback'=>$faker->text,
                'created_at'=>$faker->date,
                'updated_at'=>$faker->date
            ]);
        }
        */
    }

}
