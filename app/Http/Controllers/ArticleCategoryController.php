<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\ArticleCategory;
use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('Article Category Access'), 403);
        $this->data['articleCategories'] = ArticleCategory::where('status', '1')->get();

        return view('article_categories.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('Article Category Create'), 403);

        $this->data['action'] = "/article_categories";
        return view('article_categories.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleCategoryRequest $request)
    {
        abort_if(Gate::denies('Article Category Create'), 403);

        ArticleCategory::create($request->all());

        return redirect('article_categories')->with('success', 'New Category has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticleCategory $articleCategory)
    {
        abort_if(Gate::denies('Article Category Update'), 403);

        $this->data['article_categories_data'] = $articleCategory;
        $this->data['action'] = "/article_categories/" . $articleCategory->slug;
        return view('article_categories.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleCategoryRequest  $request
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleCategoryRequest $request, ArticleCategory $articleCategory)
    {
        abort_if(Gate::denies('Article Category Update'), 403);

        $request['slug'] = SlugService::createSlug(ArticleCategory::class, 'slug', $request->name);

        ArticleCategory::find($articleCategory->id)
            ->update($request->all());

        return redirect('/article_categories')->with('success', 'Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $articleCategory)
    {
        abort_if(Gate::denies('Article Category Delete'), 403);

        ArticleCategory::find($articleCategory->id)
            ->update(['status' => FALSE]);

        return redirect('/article_categories')->with('success', 'Category has been Deleted!');
    }
}
