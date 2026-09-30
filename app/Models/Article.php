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
        'meta_title',
        'slug',
        'excerpt',
        'meta_description',
        'content',
        'published_at',
        'highlite',
        'tags',
        'meta_keywords',
        'canonical_url',
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

    /**
     * Accessor SEO Title (fallback ke title utama)
     */
    public function getSeoTitleAttribute(): string
    {
        return !empty($this->meta_title) ? $this->meta_title : ($this->title ?? '');
    }

    /**
     * Accessor SEO Description (fallback ke excerpt atau ringkasan konten)
     */
    public function getSeoDescriptionAttribute(): string
    {
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }
        return !empty($this->excerpt) ? $this->excerpt : \Illuminate\Support\Str::limit(strip_tags($this->content ?? ''), 160);
    }

    /**
     * Accessor SEO Keywords (fallback ke tags)
     */
    public function getSeoKeywordsAttribute(): string
    {
        return !empty($this->meta_keywords) ? $this->meta_keywords : ($this->tags ?? '');
    }

    /**
     * Accessor Full URL Image
     */
    public function getSeoImageAttribute(): string
    {
        if (!empty($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }
        return asset(settings()['favicon'] ?? '');
    }

    /**
     * Schema.org JSON-LD Structured Data untuk Google Rich Snippets
     */
    public function getSchemaJsonLd(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('article.show', $this->slug),
            ],
            'headline' => $this->seo_title,
            'description' => $this->seo_description,
            'image' => $this->seo_image,
            'author' => [
                '@type' => 'Person',
                'name' => $this->author ? $this->author->name : config('app.name'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(settings()['favicon'] ?? ''),
                ],
            ],
            'datePublished' => date('c', strtotime($this->published_at)),
            'dateModified' => $this->updated_at ? $this->updated_at->toIso8601String() : date('c', strtotime($this->published_at)),
        ];
    }
}
