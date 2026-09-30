@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if(isset($article_data)){
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $article_data)->where('title', '!=', $breadcrumb->title)->last();
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
                    {{ isset($article_data) ? Breadcrumbs::render(Request::route()->getName(), $article_data)  : Breadcrumbs::render(Request::route()->getName()) }}
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form class="form theme-form" method="post" action="{{ $action }}" enctype="multipart/form-data">
                        @isset($article_data) @method('put') @endisset
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Category</label>
                                        <div class="col-sm-9">
                                            <select name="article_category_id" id="article_category_id" class="js-example-basic-single col-sm-12 @error('article_category_id') is-invalid @enderror">
                                                @foreach($categories as $category)
                                                    @if(isset($article_data) && $article_data->category->id == $category->id )
                                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                                    @elseif(!is_null(old('article_category_id')) && old('article_category_id') == $category->id)
                                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                                    @else
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('article_category_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Title <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('title') is-invalid @enderror" name="title" id="title" type="text" value="{{ (isset($article_data))? old('title',$article_data->title) : old('title') }}" placeholder="Judul Artikel" required autofocus>
                                            @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="slug">SEO Slug</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-text text-muted font-monospace text-sm">{{ url('/article') }}/</span>
                                                <input class="form-control @error('slug') is-invalid @enderror font-monospace" id="slug" name="slug" type="text" value="{{ (isset($article_data))? old('slug',$article_data->slug) : old('slug') }}" placeholder="judul-artikel-anda">
                                            </div>
                                            <small class="text-muted">Biarkan kosong untuk generate slug otomatis dari judul artikel.</small>
                                            @error('slug')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="published_at">Published at <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control datepicker-here digits @error('published_at') is-invalid @enderror" name="published_at" id="published_at" type="text" value="{{ (isset($article_data))? old('published_at',date('d-m-Y', strtotime($article_data->published_at))) : old('published_at', date('d-m-Y')) }}" placeholder="DD-MM-YYYY" required autocomplete="off" data-language="id">
                                            @error('published_at')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="highlite">Highlight</label>
                                        <div class="col-sm-9">
                                            <div class="media-body icon-state switch-outline">
                                                <label class="switch">
                                                    <input type="checkbox" name="highlite" id="highlite" {{ (isset($article_data))? (old('highlite',$article_data->highlite))? "Checked":"" : (old('highlite'))? "Checked":"" }}><span class="switch-state bg-success"></span>
                                                </label>
                                            </div>
                                            @error('highlite')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="tags" class="col-sm-3 col-form-label">Tags</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('tags') is-invalid @enderror tags" name="tags" id="tags" type="text" value="{{ (isset($article_data))? old('tags',$article_data->tags) : old('tags') }}" placeholder="Tag artikel, pisahkan dengan koma" autocomplete="off">
                                            @error('tags')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="image">Featured Image <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('image') is-invalid @enderror" id="image" name="image" type="file" onchange="previewImage()" {{ isset($article_data) ? '' : 'required' }}>
                                            <img class="img-preview img-fluid mt-3 b-r-10" @isset($article_data) src="{{ asset('storage/'.$article_data->image_path) }}" alt="{{ $article_data->title }}" @endisset style="max-height: 150px; max-width: 150px;"/>
                                            @error('image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="content">Content <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            @error('content')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror

                                            <div class="theme-form">
                                                <div class="mb-3">
                                                    <textarea name="content" id="content" cols="30" rows="10">
                                                    {{ (isset($article_data))? old('content',$article_data->content) : old('content') }}
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-search me-2"></i> Pengaturan SEO (Search Engine Optimization)</h5>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="meta_title">Meta Title</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" type="text" value="{{ (isset($article_data))? old('meta_title', $article_data->meta_title) : old('meta_title') }}" placeholder="Judul SEO spesifik untuk Google (opsional)">
                                            <small class="text-muted">Maksimal disarankan: 60 karakter. Jika kosong, judul artikel akan otomatis digunakan.</small>
                                            @error('meta_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="meta_description">Meta Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3" placeholder="Deskripsi ringkas yang tampil di hasil pencarian Google">{{ (isset($article_data))? old('meta_description', $article_data->meta_description) : old('meta_description') }}</textarea>
                                            <small class="text-muted">Disarankan 150-160 karakter agar snippet Google tampil utuh.</small>
                                            @error('meta_description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="meta_keywords">Meta Keywords</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" type="text" value="{{ (isset($article_data))? old('meta_keywords', $article_data->meta_keywords) : old('meta_keywords') }}" placeholder="kata kunci utama, pisahkan dengan koma">
                                            <small class="text-muted">Jika kosong, kolom tags di atas akan digunakan sebagai kata kunci.</small>
                                            @error('meta_keywords')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="canonical_url">Canonical URL</label>
                                        <div class="col-sm-9">
                                            <input class="form-control @error('canonical_url') is-invalid @enderror" id="canonical_url" name="canonical_url" type="url" value="{{ (isset($article_data))? old('canonical_url', $article_data->canonical_url) : old('canonical_url') }}" placeholder="https://example.com/original-article-url">
                                            <small class="text-muted">Gunakan jika artikel ini disadur atau dipublikasikan ulang dari sumber web lain.</small>
                                            @error('canonical_url')
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
                                            <div class="p-3 border rounded bg-white shadow-sm" style="max-width: 650px;">
                                                <div class="text-success small mb-1 font-monospace" id="serp_url">{{ url('/article') }}/...</div>
                                                <h6 class="text-primary mb-1 fw-bold" id="serp_title">Judul Artikel Preview</h6>
                                                <p class="text-muted small mb-0" id="serp_desc">Deskripsi artikel akan ditampilkan di sini sebagai preview cuplikan Google...</p>
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
    <script src="{{ asset('/assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/assets/js/editor/ckeditor/styles.js') }}"></script>
    <script>
        CKEDITOR.replace('content', {
            on: {
                contentDom: function (evt) {
                    // Allow custom context menu only with table elemnts.
                    evt.editor.editable().on('contextmenu', function (contextEvent) {
                        var path = evt.editor.elementPath();

                        if (!path.contains('table')) {
                            contextEvent.cancel();
                        }
                    }, null, null, 5);
                }
            }
        });

        function previewImage(){
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent){
                imgPreview.src = oFREvent.target.result;
            }
        }

        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        }

        function updateSerpPreview() {
            const titleVal = $('#title').val() || 'Judul Artikel';
            const metaTitleVal = $('#meta_title').val() || titleVal;
            const slugVal = $('#slug').val() || slugify(titleVal);
            const descVal = $('#meta_description').val() || 'Deskripsi artikel akan ditampilkan di sini sebagai preview cuplikan Google...';

            $('#serp_title').text(metaTitleVal + ' | {{ config("app.name") }}');
            $('#serp_url').text('{{ url("/article") }}/' + slugVal);
            $('#serp_desc').text(descVal);
        }

        $('#title').on('input', function() {
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
