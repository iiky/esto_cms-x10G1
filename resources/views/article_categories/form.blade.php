@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if(isset($article_categories_data)){
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $article_categories_data)->where('title', '!=', $breadcrumb->title)->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())->where('title', '!=', $breadcrumb->title)->last();
    }
@endphp

@extends('layouts.backend.main', ['title' => 'Dashboard | '.config('app.name'), 'sub_title' => $sub_title])

@section('container')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    {{ isset($article_categories_data) ? Breadcrumbs::render(Request::route()->getName(), $article_categories_data)  : Breadcrumbs::render(Request::route()->getName()) }}
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form class="form theme-form" method="post" action="{{ $action }}">
                        @isset($article_categories_data) @method('put') @endisset
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Category Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="@if(isset($article_categories_data)){{old('name',$article_categories_data->name)}}@else{{old('name')}}@endif" placeholder="Nama Kategori" required autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">SEO Slug</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-text text-muted font-monospace text-sm">{{ url('/article_categories') }}/</span>
                                                <input class="form-control @error('slug') is-invalid @enderror font-monospace" id="slug" name="slug" type="text" value="@if(isset($article_categories_data)){{old('slug',$article_categories_data->slug)}}@else{{old('slug')}}@endif" placeholder="kategori-slug">
                                            </div>
                                            <small class="text-muted">Biarkan kosong untuk generate slug otomatis dari nama kategori.</small>
                                            @error('slug')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-search me-2"></i> Pengaturan SEO (Search Engine Optimization)</h5>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Meta Title</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" type="text" value="@if(isset($article_categories_data)){{old('meta_title',$article_categories_data->meta_title)}}@else{{old('meta_title')}}@endif" placeholder="Judul SEO Kategori (opsional)">
                                            <small class="text-muted">Maksimal disarankan: 60 karakter. Jika kosong, nama kategori akan digunakan.</small>
                                            @error('meta_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Meta Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3" placeholder="Deskripsi meta untuk mesin pencari Google">{{ isset($article_categories_data) ? old('meta_description', $article_categories_data->meta_description) : old('meta_description') }}</textarea>
                                            <small class="text-muted">Disarankan 150-160 karakter agar snippet Google tampil optimal.</small>
                                            @error('meta_description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Meta Keywords</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" type="text" value="@if(isset($article_categories_data)){{old('meta_keywords',$article_categories_data->meta_keywords)}}@else{{old('meta_keywords')}}@endif" placeholder="kata kunci, pisahkan dengan koma">
                                            @error('meta_keywords')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Google Search Snippet Preview -->
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Google SERP Preview</label>
                                        <div class="col-sm-9">
                                            <div class="p-3 border rounded bg-white shadow-sm" style="max-width: 600px;">
                                                <div class="text-success small mb-1 font-monospace" id="serp_url">{{ url('/article_categories') }}/...</div>
                                                <h6 class="text-primary mb-1 fw-bold" id="serp_title">Title Kategori</h6>
                                                <p class="text-muted small mb-0" id="serp_desc">Deskripsi singkat kategori akan muncul di sini sesuai input meta description...</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-sm-9 offset-sm-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <a class="btn btn-danger" href="{{ $breadcrumb_parent->url }}">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    function updateSerpPreview() {
        const nameVal = $('#name').val() || 'Judul Kategori';
        const titleVal = $('#meta_title').val() || nameVal;
        const slugVal = $('#slug').val() || slugify(nameVal);
        const descVal = $('#meta_description').val() || 'Kategori artikel ' + nameVal;

        $('#serp_title').text(titleVal + ' | {{ config("app.name") }}');
        $('#serp_url').text('{{ url("/article_categories") }}/' + slugVal);
        $('#serp_desc').text(descVal);
    }

    $('#name').on('input', function() {
        if (!$('#slug').data('touched')) {
            $('#slug').val(slugify($(this).val()));
        }
        updateSerpPreview();
    });

    $('#slug').on('input', function() {
        $(this).data('touched', true);
        updateSerpPreview();
    });

    $('#meta_title, #meta_description').on('input', function() {
        updateSerpPreview();
    });

    $(document).ready(function() {
        updateSerpPreview();
    });
</script>
@endsection