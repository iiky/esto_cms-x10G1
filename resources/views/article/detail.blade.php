@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
    $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $article_data)->where('title', '!=', $breadcrumb->title)->last();
@endphp

@extends('layouts.backend.main', [
    'title' => $title ?? ($article_data->seo_title . ' | ' . config('app.name')),
    'sub_title' => $sub_title,
    'description' => $description ?? $article_data->seo_description,
    'keyword' => $keyword ?? $article_data->seo_keywords,
    'og_image' => $og_image ?? $article_data->seo_image,
    'canonical_url' => $canonical_url ?? route('article.show', $article_data->slug),
    'og_type' => 'article',
    'schema_json_ld' => $schema_json_ld ?? $article_data->getSchemaJsonLd()
])

@section('container')

@if(session()->has('success'))
    <script>
        $(document).ready(function() {
            swal("Success!", "{{ session('success') }}", "success");
        });
    </script>
@endif

@php
    $published_at = strtotime($article_data->published_at)
@endphp
    
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                {{ Breadcrumbs::render(Request::route()->getName(), $article_data) }}
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="blog-single">
                <div class="blog-box blog-details"><img class="img-fluid w-100 b-r-10" src="{{ asset('storage/'.$article_data->image_path) }}" alt="{{ $article_data->title }}">
                    <div class="blog-details">
                        <ul class="blog-social">
                            <li>{{ \Carbon\Carbon::parse($article_data->published_at)->isoFormat('dddd, D MMMM Y') }}</li>
                            <li><i class="icofont icofont-files"></i>{{ $article_data->category ? $article_data->category->name : 'Uncategorized' }}</li>
                            <li><i class="icofont icofont-user"></i>{{ $article_data->author ? $article_data->author->name : 'Admin' }}</li>
                            <li><a class="btn btn-danger btn-sm" href="{{ $breadcrumb_parent->url }}">Back</a></li>
                        </ul>
                        <h1 class="h3 font-weight-bold mt-2">{{ $article_data->title }}</h1>
                        <div class="single-blog-content-top my-3">{!! $article_data->content !!}</div>

                        @if(!empty($article_data->tags))
                            <div class="article-tags mt-4 pt-3 border-top">
                                <span class="fw-bold me-2"><i class="icofont icofont-tags"></i> Tags:</span>
                                @foreach(explode(',', $article_data->tags) as $tag)
                                    @if(trim($tag))
                                        <span class="badge badge-light-primary me-1">{{ trim($tag) }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection