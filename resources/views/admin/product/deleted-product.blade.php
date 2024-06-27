@extends('layouts.app', ['title' => 'Product'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">Deleted Product</h3>
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
                                Deleted Product
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="page-content">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Total Review</th>
                                    <th>Rating</th>
                                    <th>Stock</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @foreach ($products as $product)
                                    <tr id="index_{{ $product->id }}">
                                        <td>
                                            @if ($product->product_image)
                                                @if (Str::startsWith($product->product_image, 'uploads/'))
                                                    <img src="{{ asset('storage/' . $product->product_image) }}"
                                                        class="img-fluid rounded tw-w-16 tw-h-16"
                                                        alt="{{ $product->product_name }}">
                                                @else
                                                    <img src="{{ asset($product->product_image) }}"
                                                        class="img-fluid rounded tw-w-16 tw-h-16"
                                                        alt="{{ $product->product_name }}">
                                                @endif
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>
                                            @if ($product->category)
                                                {{ $product->category->category_name }}
                                            @else
                                                <i class="tw-text-xs">Category Deleted</i>
                                            @endif
                                        </td>
                                        <td class="text-capitalize">{{ $product->type }}</td>
                                        <td class="text-end">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>{{ $product->reviews_count }}</td>
                                        <td class="tw-text-sm tw-text-nowrap">
                                            @if ($product->average_rating == 0)
                                                0
                                            @else
                                                {{ $product->average_rating }}
                                            @endif
                                            / 5
                                            <span class="tw-ml-1">
                                                <i class="bi bi-star-fill tw-text-yellow-200"></i>
                                            </span>

                                        </td>
                                        <td class="text-center">
                                            @if ($product->stock == 0)
                                                <span class="badge bg-danger">0</span>
                                            @else
                                                <span class="badge bg-success">{{ $product->stock }}</span>
                                            @endif
                                        </td>
                                        <td class="tw-text-nowrap">
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm me-1"
                                                data-id="{{ $product->id }}" id="btn-restore">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </a>
                                            {{-- <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                                                data-id="{{ $product->id }}" id="btn-delete">
                                                <i class="bi bi-trash"></i>
                                            </a> --}}
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

    @include('layouts.loader')

    <div id="basic" class="!tw-hidden"></div>
    <div id="basic-edit" class="!tw-hidden"></div>
@endsection
@section('js')
    <script>
        $("#loader").hide();

        $(document).on("click", "#btn-delete", function() {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loader").show();
                    $.ajax({
                        url: `/products/force-delete/${id}`,
                        type: "DELETE",
                        data: {
                            _token: token
                        },
                        success: function(response) {
                            $("#loader").hide();
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                })
                                $("#index_" + id).remove();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                    showConfirmButton: true
                                })
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            $("#loader").hide();
                        }
                    })
                }
            })
        })
        $(document).on("click", "#btn-restore", function() {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'Are you sure?',
                text: "Data will be restored!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loader").show();
                    $.ajax({
                        url: `/products/restore/${id}`,
                        type: "POST",
                        data: {
                            _token: token
                        },
                        success: function(response) {
                            $("#loader").hide();
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                })
                                $("#index_" + id).remove();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                    showConfirmButton: true
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection
