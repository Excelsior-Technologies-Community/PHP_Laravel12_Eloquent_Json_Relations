<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'post_ids'];

    
    protected $casts = [
        'post_ids' => 'array',
    ];

    public function getPostsAttribute()
    {
        return Post::whereIn('id', $this->post_ids ?? [])->get();
    }
}