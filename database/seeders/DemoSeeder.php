<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create Posts
        $post1 = Post::create([
            'title' => 'Laravel 12 Guide',
            'content' => 'Learning Laravel 12'
        ]);

        $post2 = Post::create([
            'title' => 'Eloquent JSON Relations',
            'content' => 'Working with JSON columns'
        ]);

        // Create User with JSON relation
        User::create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'), // safer for Laravel 12
            'post_ids' => [$post1->id, $post2->id] // ensure proper JSON
        ]);
    }
}