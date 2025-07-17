<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->user() ; 
        $this->seedTask();
    }


    public function user()
    {
        for ($i = 1; $i <= 8; $i++) {
            User::create([
                'name' => "name " . $i,
                'email' => "name-" . $i . "@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('11111111'),
                'remember_token' => Str::random(10),
            ]);
        }
    }

    public function seedTask()
    {
        for ($i = 1; $i <= 100; $i++) {
            $task = Task::create([
                'user_id' => rand(1, 8),
                'title' => "title : " . $i,
                'is_done' => $i % 5 == 0 ? true : false,
            ]);
        }
    }
}
