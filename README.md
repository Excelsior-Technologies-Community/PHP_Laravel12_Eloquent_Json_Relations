# PHP_Laravel12_Eloquent_Json_Relations

## Project Introduction

PHP_Laravel12_Eloquent_Json_Relations is a Laravel 12 demonstration project that teaches how to create and use Eloquent relationships stored in JSON columns using the package:

staudenmeir/eloquent-json-relations

In traditional Eloquent relationships, foreign keys are stored in a dedicated column (like user_id in posts). This project demonstrates an alternative approach where related IDs are stored as arrays in JSON columns, enabling:

- Flexible schema design for dynamic relationships

- Storing multiple related IDs without creating a separate pivot table

- Efficient querying and retrieving related data via Eloquent methods

This approach is particularly useful when working with modern MySQL or PostgreSQL JSON columns.

---

## Project Overview

This project guides you step-by-step to:

- Setup Laravel 12 and configure the database

- Install the staudenmeir/eloquent-json-relations package

- Create models and migrations with JSON columns for storing relationships

- Seed the database with example data for posts and users

- Define JSON-based relationships using hasManyJson in Eloquent models

- Retrieve related records using standard Eloquent queries

- Perform queries on JSON relationships safely in Laravel 12 + PHP 8.2

---

## Step 1 — Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_Eloquent_Json_Relations "12.*"
```

Move inside project:

```bash
cd PHP_Laravel12_Eloquent_Json_Relations
```

Check Laravel version:

```bash
php artisan --version
```

It should show Laravel 12.

---

## Step 2 — Configure Database

Open .env

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eloquent_json_relations
DB_USERNAME=root
DB_PASSWORD=
```

Create database manually in phpMyAdmin or MySQL

or

run migration command:

```bash
php artisan migrate
```

---

## Step 3 — Install Eloquent JSON Relations Package

```bash
composer require staudenmeir/eloquent-json-relations
```

This package allows Eloquent to define relationships using JSON columns.

---

## Step 4 — Create Models and Migrations

We will create:


- User

- Post


Relationship:

A User has many Posts.

But instead of normal foreign key,
Post IDs will be stored inside a JSON column in users table.

Create Post Model + Migration

```bash
php artisan make:model Post -m
```
Open migration:

database/migrations/xxxx_create_posts_table.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

Modify Users Migration

Open:

database/migrations/xxxx_create_users_table.php

Add JSON column:

```
$table->json('post_ids')->nullable();
```

Final users table:

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->json('post_ids')->nullable(); // JSON column
    $table->rememberToken();
    $table->timestamps();
});
```

## Step 5 — Run Migration

```bash
php artisan migrate
```

## Step 6 — Configure Models

### User.php

File: app/Models/User.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use App\Models\Post; // Make sure to import Post

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasJsonRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'post_ids', // JSON column
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'post_ids' => 'array', // JSON column cast
    ];

    // ------------------------------
    // JSON Relationship
    // ------------------------------
    public function posts()
    {
        return $this->hasManyJson(Post::class, 'id', 'post_ids');
    }
}
```

### Post.php

File: app/Models/Post.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content'
    ];
}
```

---

## Step 7 — Create Seeder

```bash
php artisan make:seeder DemoSeeder
```
Open:

database/seeders/DemoSeeder.php

```php
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
```

### Register seeder:

database/seeders/DatabaseSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Optionally keep the default User factory
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Call your DemoSeeder (JSON relations)
        $this->call(\Database\Seeders\DemoSeeder::class);
    }
}
```
Run:

```bash
php artisan db:seed
```

---

## Step 8 — Test Relationship in Route

Open:

routes/web.php

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Models\Post;

Route::get('/test', function() {
    // Correct query for integer IDs
    $posts = Post::whereIn('id', [1,2])->get();
    return $posts;
});

Route::get('/', function () {
    return view('welcome');
});
```

## Step 9 — Run Development Server

Start server:

```bash
php artisan serve
```

Visit:

```bash
http://127.0.0.1:8000/test
```

---

## Output

<img width="1825" height="1082" alt="Screenshot 2026-02-20 171315" src="https://github.com/user-attachments/assets/28636fff-055e-481c-b766-b57aea29cecf" />

---

## Project Structure

```
PHP_Laravel12_Eloquent_Json_Relations/
│
├── app/
│   └── Models/
│       ├── User.php
│       └── Post.php
│
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   └── create_posts_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── DemoSeeder.php
│
├── routes/
│   └── web.php
│
├── .env
└── README.md
```

---

Your PHP_Laravel12_Eloquent_Json_Relations Project is now ready!
