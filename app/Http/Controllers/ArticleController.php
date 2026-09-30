<?php

namespace App\Http\Controllers;

use App\Traits\ArticlesAuthorizable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ArticleController extends Controller
{

    use ArticlesAuthorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['articles'] = Article::all();

        return view('article.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['categories'] = ArticleCategory::all();
        $this->data['action'] = route('article.store');
        return view('article.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $payload = $request->validated();
        $payload['highlite'] = $request->boolean('highlite');
        $payload['content'] = clean_html($payload['content']);
        $payload['image_path'] = $request->file('image')->store('article-images', 'public');
        $payload['published_at'] = date('Y-m-d', strtotime($request->published_at));
        $payload['user_id'] = auth()->id();
        $payload['excerpt'] = Str::limit(strip_tags($request->content), 200);

        if (empty($payload['slug'])) {
            $payload['slug'] = SlugService::createSlug(Article::class, 'slug', $payload['title']);
        } else {
            $payload['slug'] = Str::slug($payload['slug']);
        }

        // Default meta fallback jika tidak diisi manual
        if (empty($payload['meta_title'])) {
            $payload['meta_title'] = $payload['title'];
        }
        if (empty($payload['meta_description'])) {
            $payload['meta_description'] = $payload['excerpt'];
        }
        if (empty($payload['meta_keywords']) && !empty($payload['tags'])) {
            $payload['meta_keywords'] = $payload['tags'];
        }

        Article::create($payload);

        return redirect()->route('article.index')->with('success', 'New article has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->data['article_data'] = $article;
        $this->data['title'] = $article->seo_title . ' | ' . config('app.name');
        $this->data['description'] = $article->seo_description;
        $this->data['keyword'] = $article->seo_keywords;
        $this->data['canonical_url'] = $article->canonical_url ?: route('article.show', $article->slug);
        $this->data['og_image'] = $article->seo_image;
        $this->data['og_type'] = 'article';
        $this->data['schema_json_ld'] = $article->getSchemaJsonLd();

        return view('article.detail', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->data['categories'] = ArticleCategory::all();

        $this->data['article_data'] = $article;
        $this->data['action'] = route('article.update',$article->slug);

        return view('article.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $payload = $request->validated();
        $payload['highlite'] = $request->boolean('highlite');
        $payload['content'] = clean_html($payload['content']);

        if ($request->hasFile('image')) {
            if ($article->image_path && Storage::disk('public')->exists($article->image_path)) {
                Storage::disk('public')->delete($article->image_path);
            }
            $payload['image_path'] = $request->file('image')->store('article-images', 'public');
        }

        $payload['published_at'] = date('Y-m-d', strtotime($request->published_at));
        $payload['excerpt'] = Str::limit(strip_tags($request->content), 200);

        if (!empty($payload['slug'])) {
            $payload['slug'] = Str::slug($payload['slug']);
        } elseif ($request->title != $article->title) {
            $payload['slug'] = SlugService::createSlug(Article::class, 'slug', $request->title);
        }

        $article->update($payload);

        return redirect()->route('article.index')->with('success', 'Article ' . $article->title . ' has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if ($article->image_path && Storage::disk('public')->exists($article->image_path)) {
            Storage::disk('public')->delete($article->image_path);
        }
        $article->delete();

        return redirect()->route('article.index')->with('success', 'Article ' . $article->title . ' has been deleted!');
    }
}
