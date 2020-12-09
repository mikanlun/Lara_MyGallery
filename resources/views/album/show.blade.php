@extends('layouts.gallery')

@section('title', 'アルバム詳細')

@section('content')

<section class="container-fluid">
    <div class="card  border border-dark mb-3">
        <div class="card-header font-weight-bold">アルバム</div>
        <div class="card-body text-dark mx-3">
            <form action="">
                <fieldset disabled>
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label bg-info text-white rounded">タイトル</label>
                        <div class="col-sm-10">
                            <input type="text" name="title"  value="{{ $album->title }}" autofocus class="form-control col-sm-10" id="title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-sm-2 col-form-label bg-info text-white rounded">画像</label>
                           <label class="text-muted">[ 画像名 : {{ $album->image }} ]</label>
                    </div>
                    <div class="form-group row">
                        <img class="card-img-bottom"
                              src="/storage/{{ $album->path }}/{{ $album->image }}"
                              alt="{{ $album->image }}">
                    </div>
                    <div class="form-group row">
                        <label for="comment" class="col-sm-2 col-form-label bg-info text-white rounded">コメント</label>
                        <div class="col-sm-10">
                            <textarea name="comment" class="form-control ccol-sm-10"" id="comment" row="3">{{ $album->comment }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="comment" class="col-sm-2 col-form-label bg-info text-white rounded">ユーザー</label>
                        <div class="col-sm-10">
                            <input type="text" name="name"  value="{{ $user->name }} : {{ $album->updated_at }}"  class="form-control col-sm-10" id="title">
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        @if(Auth::check() && (Auth::user()->id == $album->user_id))
                        <a class="btn btn-primary btn-lg mr-3" href="/album/{{ $album->id }}/edit" role="button">{{ __('messages.btn_label.edit') }}</a>
                        @endif
                        <a class="btn btn-warning btn-lg mr-3" href="/" role="button">{{ __('messages.btn_label.back') }}</a>
                    </div>
                </div>
            </form>
        </div><!-- .card-body -->
    </div><!-- .card -->
</section>

@endsection
