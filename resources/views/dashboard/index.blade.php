@php $sub_title = 'Dashboard' @endphp
@extends('layouts.backend.main', ['title' => 'Dashboard | '.config('app.name'), 'sub_title' => $sub_title])

@section('container')
<div class="container-fluid">        
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard"><i data-feather="home"></i></a></li>
          <li class="breadcrumb-item">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-12">
  <div class="card">
    <div class="card-body typography">
      <h3>Welcome Back,<small class="text-muted">{{ auth()->user()->name }}</small></h3>
    </div>
  </div>
</div>
@endsection