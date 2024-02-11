<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // users seed
        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@perdana.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory(10)->create();

        // other seeders
        $this->call([
            // category seed
            CategorySeeder::class,
            // product seed
            ProductSeeder::class,
        ]);
    }
}
