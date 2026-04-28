<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'post_ids'
    ];

    protected $casts = [
        'post_ids' => 'array'
    ];

    // ✅ CORRECT RELATION FOR JSON SYSTEM
    public function getPostsAttribute()
    {
        return \App\Models\Post::whereIn('id', $this->post_ids ?? [])->get();
    }
}