@extends('layouts.app-user', ['title' => 'Blog'])

@section('main-content')
    <div class="row">
        @foreach ($blogs as $blog)
            <div class="col-md-12">
                <div style="max-height: 15rem;" class="card mb-3 overflow-hidden">
                    <div class="row g-0">
                        @if ($blog->blog_image != null)
                            <div class="col-md-4">
                                @if (Str::startsWith($blog->blog_image, 'uploads/'))
                                    <img src="{{ asset('storage/' . $blog->blog_image) }}"
                                        class="img-fluid rounded-start !tw-h-60 !tw-w-full" alt="{{ $blog->title }}">
                                @else
                                    <img src="{{ asset($blog->blog_image) }}"
                                        class="img-fluid rounded-start !tw-h-60 !tw-w-full" alt="{{ $blog->title }}">
                                @endif
                            </div>
                            <div class="col-md-8">
                            @else
                                <div class="col-md-12">
                        @endif
                        <div class="card-body">
                            <a href="/blog/{{ $blog->slug }}">
                                <h5 class="card-title !tw-text-lg">{{ $blog->title }}</h5>
                            </a>
                            <span class="card-text mb-3 d-flex justify-content-between">
                                <small class="text-body-secondary">{{ $blog->created_at->diffForHumans() }}</small>
                                <small class="text-body-secondary">
                                    <a href="/blog/{{ $blog->slug }}">
                                        Read more...
                                    </a>
                                </small>
                            </span>
                            <div class="card-text mb-3 ellipsis">
                                {!! $blog->description !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
    @endforeach
    </div>
@endsection

@section('css')
    <style>
        .ellipsis {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 4rem;
        }
    </style>
@endsection
