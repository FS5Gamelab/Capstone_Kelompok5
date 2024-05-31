@extends('layouts.app', ['title' => 'Product'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">Product</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Product
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="page-content">
                <div class="d-flex mt-4 justify-content-end">
                    <a href="/product/create" class="btn btn-primary mb-3"><i class="bi bi-plus-lg"></i>
                        Add New Product
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @if ($product->product_image)
                                            <td>
                                                <img src="{{ asset('storage/' . $product->product_image) }}"
                                                    alt="{{ $product->product_name }}" class="w-16 h-16">
                                            </td>
                                        @else
                                            <td>
                                                No Image
                                            </td>
                                        @endif
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->category->category_name }}</td>
                                        <td>{{ $product->type }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td class="text-center">
                                            @if ($product->in_stock)
                                                <i class="bi bi-check text-success"></i>
                                            @else
                                                <i class="bi bi-x text-danger"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/products/{{ $product->id }}" class="btn btn-sm btn-info me-2">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/products/{{ $product->id }}/edit"
                                                class="btn btn-sm btn-primary me-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="/products/{{ $product->id }}" method="POST" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('css')
    @vite(['resources/scss/pages/simple-datatables.scss', 'resources/js/pages/simple-datatables.js'])
@endsection
