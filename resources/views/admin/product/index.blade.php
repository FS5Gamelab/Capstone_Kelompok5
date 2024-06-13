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
                <div class="d-flex mt-4 justify-content-between">
                    <a href="{{ route('products.deleted') }}" class="btn btn-danger mb-3"><i class="bi bi-trash"></i>
                        Deleted Product
                    </a>
                    <a href="javascript:void(0)" id="btn-add" class="btn btn-primary mb-3"><i class="bi bi-plus-lg"></i>
                        Add New Product
                    </a>
                </div>
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
                                    <th>Status</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @foreach ($products as $product)
                                    <tr id="index_{{ $product->id }}">
                                        @if ($product->product_image)
                                            <td>

                                                @if (Str::startsWith($product->product_image, 'uploads/'))
                                                    <img src="{{ asset('storage/' . $product->product_image) }}"
                                                        class="img-fluid rounded tw-w-16 !tw-h-16"
                                                        alt="{{ $product->product_name }}">
                                                @else
                                                    <img src="{{ asset($product->product_image) }}"
                                                        class="img-fluid rounded tw-w-16 !tw-h-16"
                                                        alt="{{ $product->product_name }}">
                                                @endif
                                            </td>
                                        @else
                                            <td>
                                                No Image
                                            </td>
                                        @endif
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
                                            @elseif ($product->average_rating == 5)
                                                5
                                            @else
                                                {{ $product->average_rating }}
                                            @endif
                                            / 5
                                            <span class="tw-ml-1">
                                                <i class="bi bi-star-fill tw-text-yellow-200"></i>
                                            </span>

                                        </td>
                                        <td class="text-center">
                                            @if ($product->in_stock)
                                                <i class="bi bi-check text-success"></i>
                                            @else
                                                <i class="bi bi-x text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="tw-text-nowrap">
                                            <a href="/products/{{ $product->slug }}" class="btn btn-sm btn-info me-2">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-id="{{ $product->id }}" id="btn-edit"
                                                class="btn btn-sm btn-primary me-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="javascript:void(0)" data-id="{{ $product->id }}" id="btn-delete"
                                                class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>
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
    @include('layouts.modal.modal-product')
@endsection
@section('js')
    <script>
        $("#loader").hide();
        $("#btn-add").click(function() {
            $("#n-product_name").val("");
            $("#n-slug").val("");
            $("#n-category_id").val("");
            $("#n-type").val("");
            $("#n-description").val("");
            $("#n-price").val("");
            $("#n-product_image").val("");
            $("#preview").hide();
            $("preview").attr("src", "");

            $("#tambahModal").modal("show");

        });
    </script>

    <script>
        $("#add-product").on('submit', function(e) {
            e.preventDefault();
            $("#tambahModal").modal("hide");
            $("#loader").show();
            $.ajax({
                url: "/products/create",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#loader").hide();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        })
                        let img;
                        if (response.product.product_image == null) {
                            img = "No Image";
                        } else {
                            if (response.product.product_image.startsWith('uploads')) {
                                img =
                                    `<img src="storage/${response.product.product_image}" alt="" class="tw-w-16 tw-h-16">`;
                            } else {
                                img =
                                    `<img src="${response.product.product_image}" alt="" class="tw-w-16 tw-h-16">`;
                            }
                        }
                        if (response.product.in_stock == 1) {
                            stk =
                                `<td class="text-center"><i class="bi bi-check text-success"></i></td>`
                        } else {
                            stk = `<td class="text-center"><i class="bi bi-x text-danger"></i></td>`
                        }
                        let newRow = `
                    <tr id="index_${response.product.id}">
                        <td>${img}</td>
                        <td>${response.product.product_name}</td>
                        <td>${response.category.category_name}</td>
                        <td>${response.product.type}</td>
                        <td class="text-end">Rp${parseInt(response.product.price.toLocaleString('id_ID'))}</td>
                        <td>0</td>
                        <td class="tw-text-sm tw-text-nowrap">
                            0 / 5
                            <span class="tw-ml-1">
                                <i class="bi bi-star-fill tw-text-yellow-200"></i>
                            </span>    
                        </td>
                        <td class="text-center">
                            ${stk}
                        </td>
                        <td class="tw-text-nowrap">
                            <a href="/products/${response.product.slug}" class="btn btn-sm btn-info me-2">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="javascript:void(0)" data-id="${response.product.id}" id="btn-edit"
                                class="btn btn-sm btn-primary me-2">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="javascript:void(0)" data-id="${response.product.id}" id="btn-delete"
                                class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;

                        $("tbody").append(newRow);


                    } else {
                        let errors = response.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errorMessages += `${errors[field]}<br>`;
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessages,
                            showConfirmButton: true,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $("#loader").hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to create product.',
                        showConfirmButton: true,
                    });
                }
            });
        });
    </script>

    <script>
        $(document).on("click", "#btn-delete", function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loader").show();
                    $.ajax({
                        url: `/products/delete/${id}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $("#loader").hide();
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                })

                                $(`#index_${id}`).remove();

                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                    showConfirmButton: true,
                                })

                            }

                        },
                        error: function(xhr, status, error) {
                            $("#loader").hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete product.',
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            })
        })
    </script>

    <script>
        $(document).on("click", "#btn-edit", function() {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
            $("#loader").show();
            $.ajax({
                url: `products/edit/${id}`,
                type: "GET",
                success: function(response) {
                    $("#loader").hide();
                    $("#id").val(response.product.id);
                    $("#slug").val(response.product.slug);
                    $("#product_name").val(response.product.product_name);
                    $("#category_id").val(response.product.category_id);
                    $("#type").val(response.product.type);
                    $("#description").val(response.product.description);
                    $("#price").val(response.product.price);
                    if (response.product.product_image == null) {
                        $("#preview2").hide();
                    } else {
                        if (response.product.product_image.startsWith('uploads')) {
                            $("#preview2").attr("src", "storage/" + response.product.product_image);
                            $("#preview2").show();
                        } else {
                            $("#preview2").attr("src", response.product.product_image);
                            $("#preview2").show();
                        }
                    }
                    // $("#preview2").attr("src", "storage/" + response.product.product_image);
                    // $("#preview2").show();
                    $("#in_stock").val(response.product.in_stock);
                    $("#update-product").attr("action", `products/${id}/update`);
                    $("#ubahModal").modal("show");
                },
                error: function(xhr, status, error) {
                    $("#loader").hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to get category.',
                        showConfirmButton: true,
                    });
                }
            });
        });
    </script>


    <script>
        $(document).on('click', '#btn-update', function(e) {
            e.preventDefault();
            let id = $("#id").val();
            $("#ubahModal").modal("hide");
            $("#loader").show();
            $.ajax({
                url: `products/${id}/update`,
                type: "POST",
                // data: {
                //     product_name: $("#product_name").val(),
                //     category_id: $("#category_id").val(),
                //     type: $("#type").val(),
                //     description: $("#description").val(),
                //     price: $("#price").val(),
                //     in_stock: $("#in_stock").val(),
                //     _token: "{{ csrf_token() }}"
                // },
                data: new FormData($("#update-product")[0]),
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#loader").hide();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: true,
                        });
                        let img;
                        let stk;
                        let rating;
                        if (response.product.product_image == null) {
                            img = "No Image";
                        } else {
                            if (response.product.product_image.startsWith('uploads')) {
                                img =
                                    `<img src="storage/${response.product.product_image}" alt="" class="tw-w-16 tw-h-16">`;
                            } else {
                                img =
                                    `<img src="${response.product.product_image}" alt="" class="tw-w-16 tw-h-16">`;
                            }
                        }

                        if (response.product.in_stock == 1) {
                            stk =
                                `<td class="text-center"><i class="bi bi-check text-success"></i></td>`
                        } else {
                            stk = `<td class="text-center"><i class="bi bi-x text-danger"></i></td>`
                        }

                        if (response.product.average_rating == 0) {
                            rating = 0;
                        } else if (response.product.average_rating == 5) {
                            rating = 5;
                        } else {
                            rating = response.product.average_rating;
                        }
                        $("#index_" + id).html(
                            `
                    <td>
                        ${img}
                    </td>
                    <td>${response.product.product_name}</td>
                    <td>${response.category.category_name}</td>
                    <td class="text-capitalize">${response.product.type}</td>
                    <td class="text-end">Rp${parseInt(response.product.price.toLocaleString('id_ID'))}</td>
                    <td>${response.product.reviews_count}</td>
                    <td class="tw-text-sm tw-text-nowrap">
                        ${rating} / 5
                        <span class="tw-ml-1">
                            <i class="bi bi-star-fill tw-text-yellow-200"></i>
                        </span>    
                    </td>
                    
                        ${stk}
                   
                    <td class="tw-text-nowrap">
                        <a href="/products/${response.product.slug}" class="btn btn-sm btn-info me-2">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="${response.product.id}" id="btn-edit"
                            class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="javascript:void(0)" data-id="${response.product.id}" id="btn-delete"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                        `
                        );
                    } else {
                        let errors = response.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errorMessages += `${errors[field]}<br>`;
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessages,
                            showConfirmButton: true,
                        });
                    }

                },
                error: function(xhr, status, error) {
                    $("#loader").hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update product.',
                        showConfirmButton: true,
                    });
                }
            });
        });
    </script>
@endsection
