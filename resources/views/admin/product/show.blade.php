@extends('layouts.app', ['title' => $product->product_name])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">{{ $product->product_name }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/products">Product</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $product->product_name }}
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
                    @if ($product->product_image == null)
                        No Image
                    @else
                        <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}">
                    @endif
                </div>
                <div class="tw-flex tw-justify-between tw-mt-4">
                    <div class="tw-w-full">
                        <label class="form-label">Category</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200 text-capitalize">
                            {{ $product->category->category_name }}</p>
                    </div>
                    <div class="tw-w-full">
                        <label class="form-label">Type</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200 text-capitalize">{{ $product->type }}</p>
                    </div>
                    <div class="tw-w-full">
                        <label class="form-label">Price</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200">{{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="tw-flex tw-justify-between tw-mt-4">
                    <div class="tw-w-full">
                        <label class="form-label">Total Review</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200">{{ $product->total_review }}</p>
                    </div>
                    <div class="tw-w-full">
                        <label class="form-label">Rating</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200">
                            @if ($product->rating == 0)
                                0
                            @elseif ($product->rating == 5)
                                5
                            @else
                                {{ $product->rating }}
                            @endif
                            / 5

                            <i class="bi bi-star-fill !tw-text-yellow-500" style="color: yellow;"></i>

                        </p>
                    </div>
                    <div class="tw-w-full">
                        <label class="form-label">Status</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200">
                            @if ($product->in_stock == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @else
                                <span class="badge bg-success">In Stock</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="tw-flex tw-mt-4">
                    <div class="tw-w-full">
                        <label class="form-label">Description</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200">{{ $product->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="review-section">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Reviews</h4>
                <div class="table-responsive">
                    <table class="table table-borderless" id="table1">
                        <thead>
                            <tr>
                                <th data-sortable="false">User</th>
                                <th data-sortable="false">Comment</th>
                                <th>Rating</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->reviews as $review)
                                <tr>
                                    <td>{{ $review->user->name }}</td>

                                    <td class="comment-column">
                                        <p>
                                            {{ $review->comment }}
                                        </p>
                                    </td>
                                    <td>
                                        @for ($i = 0; $i < $review->rating; $i++)
                                            <i class="bi bi-star-fill tw-text-yellow-500"></i>
                                        @endfor
                                        @if ($review->rating < 5)
                                            @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                <i class="bi bi-star tw-text-gray-800"></i>
                                            @endfor
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    @vite(['resources/scss/pages/simple-datatables.scss', 'resources/js/pages/simple-datatables.js'])
    <style>
        .comment-column p {
            max-width: 300px;
            /* Tentukan lebar maksimum yang sesuai */
            word-wrap: break-word;
            /* Untuk IE */
            word-break: break-word;
            /* Untuk browser modern */
        }
    </style>
@endsection
