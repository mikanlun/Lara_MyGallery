@extends('layouts.gallery')

@section('title', 'お問い合わせ（完了）')

@section('content')

<section  class="container-fluid">
    <div class="card  border border-dark mb-3">
        <div class="card-header font-weight-bold">お問い合わせ（完了）</div>
        <div class="card-body text-dark">
            <p class="text-left">{{ $name }}{!! nl2br(__('messages.contact.commit')) !!}</p>
        </div><!-- .card-body -->
    </div><!-- .card -->
    <div class="form-group row">
        <div class="col-sm-12 text-center">
           <a class="btn btn-success btn-lg mr-3" href="/" role="button">My Gallery</a>
        </div>
    </div>
</section>

@endsection
