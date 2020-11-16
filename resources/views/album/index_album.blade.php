<div class="slide" data-user_cnt='{{ $user_cnt }}' >
    {{-- スライドショー --}}
    <ul class="album-container">
    @foreach( $albums as $album )
        <li>
            <div class="card border-light mb-3">
                <div class="card-header border-light card-title">
                    <h5>{{ $album->title }}</h5>
                </div>
                <a href="/album/{{ $album->id }}">
                    <img class="card-img-top"
                          src="/storage/{{ $album->path }}/{{ $album->image }}"
                          alt="{{ $album->image }}">
                </a>
                <div class="card-body">
                    <p class="card-text">{!! nl2br(e($album->comment)) !!}</p>
                </div>
                <div class="card-footer border-light">
                    by {{ $album->name }} : {{ $album->updated_at }}
                </div>
            </div>
        </li>
    @endforeach
    </ul>
    <a href="#" class="prev">前の画像</a>
    <a href="#" class="next">次の画像</a>

    {{-- サムネイル --}}
    @foreach ($thumbnails as $thumbnail)
    <div class="card border-light bg-light mb-3">
        <div class="card-header border-light card-title">
            <div class="title text-secondary float-left"></div>
            <a class="btn btn-secondary btn-sm ml-3 float-right" href="/profile/{{ $thumbnail['user_id'] }}" role="button">プロフィール</a>
            <div class="name text-info float-right"></div>
        </div>
        <div class="card-body bg-dark">
            <ul class="thumbnail">
            @foreach( $thumbnail['user_info'] as $album )
                <li>
                    <a href="/album/{{ $album->id }}">
                        <img src="/storage/{{ $album->path }}/{{ $album->image }}"
                             data-title="{{ $album->title }}" data-name="{{ $album->user->name }}"
                             alt="{{ $album->image }}" class="img-thumbnail w-100 h-100">
                    </a>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
    @endforeach
</div>
