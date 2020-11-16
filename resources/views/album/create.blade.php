@extends('layouts.gallery')

@section('title', 'アルバム登録')

@section('content')

<section class="container-fluid">
    <div class="card  border border-dark mb-3">
        <div class="card-header font-weight-bold">アルバム登録</div>
        <div class="card-body text-dark mx-3">

            <form action="/album" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label bg-info text-white rounded">タイトル</label>
                    <div class="col-sm-10">
                        <input type="text" name="title"  value="{{ old('title') }}" autofocus class="form-control @error('title') is-invalid @enderror" id="title">
                        <small class="text-muted">(20桁以下)</small>

                       @error('title')
                           <span class="invalid-feedback bg-warning" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label bg-info text-white rounded">画像</label>
                    <div class="col-sm-10">
                       <input type="file" name="image"  class="form-control-file @error('image') is-invalid @enderror" id="image">
                       <small class="text-muted">(GIF, PNG, JPEG, JPG) 2MB以下</small>

                       @error('image')
                           <span class="invalid-feedback bg-warning" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="comment" class="col-sm-2 col-form-label bg-info text-white rounded">コメント</label>
                    <div class="col-sm-10">
                        <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" id="comment" row="3">{{ old('comment') }}</textarea>

                        @error('comment')
                            <span class="invalid-feedback bg-warning" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <a class="btn btn-warning btn-lg mr-3" href="/" role="button">{{ __('messages.btn_label.back') }}</a>
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('messages.btn_label.register') }}</button>
                    </div>
                </div>

               {{-- CSRF対策 --}}
               {{ csrf_field() }}

            </form>
        </div><!-- .card-body -->
    </div><!-- .card -->
</section>
@endsection
