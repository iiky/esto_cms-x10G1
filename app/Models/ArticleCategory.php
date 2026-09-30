<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Article;

class ArticleCategory extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function article()
    {
        return $this->hasMany(Article::class, 'article_category_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Accessor SEO Title untuk Kategori
     */
    public function getSeoTitleAttribute(): string
    {
        return !empty($this->meta_title) ? $this->meta_title : ($this->name ?? '');
    }

    /**
     * Accessor SEO Description untuk Kategori
     */
    public function getSeoDescriptionAttribute(): string
    {
        return !empty($this->meta_description) ? $this->meta_description : 'Kategori artikel ' . ($this->name ?? '');
    }
}
