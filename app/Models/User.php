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