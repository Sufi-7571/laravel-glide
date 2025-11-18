<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserWithAvatarsSeeder extends Seeder
{
    public function run(): void
    {
        echo "Creating 100 users with same avatar...\n";

        for ($i = 1; $i <= 100; $i++) {
            try {
                User::create([
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'password' => bcrypt('password'),
                    'bio' => fake()->sentence(5),
                    'avatar' => 'avatars/pppf.png', 
                ]);
                
                echo "Created user {$i}/10\n";
                
            } catch (\Exception $e) {
                echo "Error creating user {$i}: " . $e->getMessage() . "\n";
            }
        }

        echo "Done! Created " . User::count() . " users.\n";
        echo "All users are using: avatars/pppf.png\n";
    }
}