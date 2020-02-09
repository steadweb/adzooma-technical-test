@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if($feed)
                @foreach ($feed as $item)
                <div class="card c-rss-item">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">{{ $item->getFeed()->getFeedTitle() }}</strong>
                        <h3 class="mb-0">
                            <a class="text-dark" href="{{ $item->getUri() }}" target="_blank">{{ $item->getTitle() }}</a>
                        </h3>
                        <div class="mb-1 text-muted">{{ $item->getPublishDate() }}</div>
                        <p class="card-text mb-auto">{{ $item->getDescription() }}</p>
                        <a href="{{ $item->getUri() }}" target="_blank">Continue</a>
                    </div>
                </div>
                @endforeach
            @else
            <div class="alert alert-warning" role="alert">
                No feeds found.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
