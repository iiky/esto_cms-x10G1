<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\ArticleCategory;
use App\Models\User;

class Article extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'article_category_id',
        'user_id',
        'image_path',
        'title',
        'slug',
        'excerpt',
        'content',
        'published_at',
        'highlite',
        'tags',
    ];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
