@php $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard' @endphp

@extends('layouts.backend.main', ['title' => 'Dashboard | '.config('app.name'), 'sub_title' => $sub_title])

@section('container')

@if(session()->has('success'))
    <script>
        $(document).ready(function() {
            swal("Succses!", "{{ session('success') }}", "success");
        });
    </script>
@endif

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                {{ Breadcrumbs::render(Request::route()->getName()) }}
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive product-table">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Article</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Published at</th>
                                    @canany(['Article Detail', 'Article Update', 'Article Delete'])
                                        <th>Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td><img class="img-fluid me-3 b-r-10" src="{{ asset('storage/'.$article->image_path) }}" style="max-height: 80px; max-width: 120px; object-fit: cover;" alt="{{ $article->title }}"></td>
                                        <td>
                                            <h6><a href="{{ route('article.show', $article->slug) }}" class="text-dark">{{ $article->title }}</a></h6>
                                            <span class="text-muted small">{{ $article->excerpt }}</span>
                                            <div class="mt-1 font-monospace text-muted small"><i class="fa fa-link"></i> /article/{{ $article->slug }}</div>
                                        </td>
                                        <td><span class="badge badge-light-primary">{{ $article->category ? $article->category->name : 'Uncategorized' }}</span></td>
                                        <td>{{ $article->author ? $article->author->name : 'Admin' }}</td>
                                        <td class="font-success">{{ \Carbon\Carbon::parse($article->published_at)->isoFormat('dddd, D MMMM Y') }}</td>
                                        @canany(['Article Detail', 'Article Update', 'Article Delete'])
                                            <td>
                                                @can('Article Detail')
                                                    <a href="{{ route('article.show',$article->slug) }}" class="txt-primary me-2" title="View Article"><i data-feather="eye"></i></a>
                                                @endcan
                                                @can('Article Update')
                                                    <a href="{{ route('article.edit',$article->slug) }}" class="txt-info me-2" title="Edit Article"><i data-feather="edit-3"></i></a>
                                                @endcan
                                                @can('Article Delete')
                                                    <form method="post" action="{{ route('article.destroy',$article->slug) }}" id="form-delete-{{ $loop->iteration }}" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <a href="javascript:void(0)" onclick="swal({ title: 'Apakah Anda yakin?', text: 'Artikel yang dihapus tidak dapat dikembalikan!', icon: 'warning', buttons: true, dangerMode: true, }).then((willDelete) => { if (willDelete) { document.getElementById('form-delete-{{ $loop->iteration }}').submit(); } });" class="txt-danger" title="Delete Article"><i data-feather="trash"></i></a>
                                                    </form>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @can('Article Create')
                        <div class="btn-showcase" style="margin-top:20px;">
                            <div class="left-header col horizontal-wrapper">
                                <ul class="horizontal-menu">
                                    <li class="mega-menu outside">
                                        <a class="nav-link" href="{{ route('article.create') }}"><i data-feather="plus"></i><span>Create New Article</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
