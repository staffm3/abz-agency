<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;
use App\Models\User;
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
         Position::factory(10)->create();
         User::factory(45)->create([
             "position_id" => fake()->randomDigit()+1,
             "position" => Position::find(fake()->randomDigit()+1)->name
         ]);
    }
}
