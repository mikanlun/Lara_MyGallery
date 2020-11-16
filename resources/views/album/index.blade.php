@extends('layouts.gallery')

@section('title', 'Welcome')

@section('content')
    {{-- 認証済みのユーザーか --}}
    @if(Auth::check())
        {{-- 認証済みのユーザーのアルバム --}}
        @if (!count($albums))
            {{-- 認証済みのユーザーのアルバムは未登録 --}}

            @include('album.index_start')

        @else
            {{-- 認証済みのユーザーのアルバムは登録済み --}}

            @include('album.index_album')

        @endif
    @else
        {{-- 一般ユーザーのアルバム --}}
        @if (!count($albums))
            {{-- 一般ユーザーのアルバムは未登録 --}}

            @include('album.index_start')

        @else
            {{-- 一般ユーザーのアルバムは登録済み --}}

            @include('album.index_album')

        @endif
    @endif
@endsection
