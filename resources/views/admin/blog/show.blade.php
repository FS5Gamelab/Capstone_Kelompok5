@extends('layouts.app', ['title' => $blog->title])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">{{ $blog->title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/blogs">Blog</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $blog->title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="tw-w-full">
                    @if ($blog->blog_image == null)
                        No Image
                    @else
                        @if (Str::startsWith($blog->blog_image, 'uploads/'))
                            <img src="{{ asset('storage/' . $blog->blog_image) }}"
                                class="img-fluid rounded-start !tw-h-60 !tw-w-full" alt="{{ $blog->title }}">
                        @else
                            <img src="{{ asset($blog->blog_image) }}" class="img-fluid rounded-start !tw-h-60 !tw-w-full"
                                alt="{{ $blog->title }}">
                        @endif
                    @endif
                </div>
                <div class="tw-flex tw-mt-4">
                    <div class="tw-w-full">
                        <small class=""><i>{{ $blog->created_at->diffForHumans() }}</i></small>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200">{!! $blog->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
