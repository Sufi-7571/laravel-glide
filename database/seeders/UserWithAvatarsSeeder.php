<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserWithAvatarsSeeder extends Seeder
{
    public function run(): void
    {
        echo "Creating 10 users with random avatars...\n";

        // Available avatar images
        $avatars = [
            'avatars/user1.jpg',
            'avatars/user2.jpg',
            'avatars/user3.jpg',
            'avatars/user4.jpg',
            'avatars/user5.jpg',
            'avatars/user6.jpg',
            'avatars/user7.jpg',
            'avatars/user8.jpg',
            'avatars/user9.jpg',
            'avatars/user10.jpg',
        ];

        for ($i = 1; $i <= 10; $i++) {
            try {
                // Pick a random avatar from the array
                $randomAvatar = $avatars[array_rand($avatars)];
                
                User::create([
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'password' => bcrypt('password'),
                    'bio' => fake()->sentence(5), // 5 words only
                    'avatar' => $randomAvatar, // Random image
                ]);
                
                echo "Created user {$i}/10 with avatar: {$randomAvatar}\n";
                
            } catch (\Exception $e) {
                echo "Error creating user {$i}: " . $e->getMessage() . "\n";
            }
        }

        echo "Done! Created " . User::count() . " users.\n";
    }
}