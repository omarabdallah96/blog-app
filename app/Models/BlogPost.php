<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author_id', 'content', 'published_date', 'featured_image','status'
    ];

    // Relationship with User model
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }



    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blogPost) {
            if (Auth::check()) {
                $blogPost->author_id = Auth::id();
            }
        });

    
    }
}
