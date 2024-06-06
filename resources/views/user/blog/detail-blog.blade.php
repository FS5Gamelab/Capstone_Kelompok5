@extends('layouts.app-user', ['title' => $blog->title])

@section('main-content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="tw-w-full">
                    @if ($blog->blog_image != null)
                        <img src="{{ asset('storage/' . $blog->blog_image) }}" alt="{{ $blog->title }}"
                            class="img-fluid rounded tw-w-full" style="max-height: 30rem;">
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
