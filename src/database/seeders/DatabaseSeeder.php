<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (User::query()->where('login', 'user2')->first()) {
            User::factory()->create([
                'login' => 'user2',
                'password' => Hash::make('user2'),
            ]);
        }
        if (User::query()->where('login', 'user1')->first()) {
            User::factory()->create([
                'login' => 'user1',
                'password' => Hash::make('user1'),
            ]);
        }

        Task::factory(10)->create();
    }
}
