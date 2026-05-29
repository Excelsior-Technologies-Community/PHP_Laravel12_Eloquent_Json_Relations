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
       
        $posts = [];
        for ($i = 1; $i <= 15; $i++) {
            $posts[] = Post::create([
                'title' => 'Post Title #' . $i,
                'content' => 'This is the content for post number ' . $i
            ]);
        }

       
        for ($i = 1; $i <= 5; $i++) {
          
            $randomPosts = collect($posts)->random(2)->pluck('id')->toArray();
            
            User::create([
                'name' => 'Demo User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'),
                'post_ids' => $randomPosts
            ]);
        }
    }
}