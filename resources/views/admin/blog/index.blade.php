@extends('layouts.app', ['title' => 'Blog'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">Blog</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Blog
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="page-content">
                <div class="d-flex mt-4 justify-content-between">
                    <a href="javascript:void(0)" id="btn-add" class="btn btn-primary mb-3"><i class="bi bi-plus-lg"></i>
                        Add New Blog
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Blog Image</th>
                                    <th>Title</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @foreach ($blogs as $blog)
                                    <tr id="index_{{ $blog->id }}">
                                        <td>
                                            @if ($blog->blog_image == null)
                                                No Image
                                            @else
                                                @if (Str::startsWith($blog->blog_image, 'uploads/'))
                                                    <img src="{{ asset('storage/' . $blog->blog_image) }}"
                                                        class="img-fluid rounded tw-w-16 !tw-h-16"
                                                        alt="{{ $blog->title }}">
                                                @else
                                                    <img src="{{ asset($blog->blog_image) }}"
                                                        class="img-fluid rounded tw-w-16 !tw-h-16"
                                                        alt="{{ $blog->title }}">
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $blog->title }}</td>
                                        <td class="tw-text-nowrap">
                                            <a href="/blogs/{{ $blog->slug }}" class="btn btn-sm btn-info me-2">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="javascript:void(0)" id="btn-edit" data-id="{{ $blog->id }}"
                                                class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0)" id="btn-delete" data-id="{{ $blog->id }}"
                                                class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>
                                            </a>
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
    @include('layouts.modal.modal-blog')
    <div id="basic" class="!tw-hidden"></div>
    <div id="basic-edit" class="!tw-hidden"></div>
@endsection
@section('js')
    <script>
        $("#loader").hide();
        $("#btn-add").click(function() {
            $("#n-title").val("");
            $("#n-slug").val("");
            $("#n-description").val("");
            $("#n-blog_image").val("");
            $("#preview").hide();
            $("preview").attr("src", "");
            $("trix-editor").val('');

            $("#tambahModal").modal("show");

        });
    </script>

    <script>
        $("#add-product").on('submit', function(e) {
            e.preventDefault();
            $("#tambahModal").modal("hide");
            $("#loader").show();
            $.ajax({
                url: "/blogs/create",
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

                        if (response.blog.blog_image == null) {
                            img = "No Image";
                        } else {
                            if (response.blog.blog_image.startsWith('uploads')) {
                                img =
                                    `<img src="storage/${response.blog.blog_image}" alt="" class="tw-w-16 tw-h-16">`;
                            } else {
                                img =
                                    `<img src="${response.blog.blog_image}" alt="" class="tw-w-16 tw-h-16">`;
                            }
                        }

                        let newRow = `
                    <tr id="index_${response.blog.id}">
                        <td>${img}</td>
                        <td>${response.blog.title}</td>
                        <td class="tw-text-nowrap">
                            <a href="/blogs/${response.blog.slug}" class="btn btn-sm btn-info me-2">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="javascript:void(0)" data-id="${response.blog.id}" id="btn-edit"
                                class="btn btn-sm btn-primary me-2">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="javascript:void(0)" data-id="${response.blog.id}" id="btn-delete"
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
                        url: `/blogs/delete/${id}`,
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
                url: `blogs/edit/${id}`,
                type: "GET",
                success: function(response) {
                    $("#loader").hide();
                    $("#id").val(response.blog.id);
                    $("#slug").val(response.blog.slug);
                    $("#title").val(response.blog.title);
                    $("#description").val(response.blog.description);
                    $("trix-editor").val(response.blog.description);
                    if (response.blog.blog_image == null) {
                        $("#preview2").hide();
                    } else {
                        if (response.blog.blog_image.startsWith('uploads')) {
                            $("#preview2").attr("src", "storage/" + response.blog.blog_image);
                            $("#preview2").show();
                        } else {
                            $("#preview2").attr("src", response.blog.blog_image);
                            $("#preview2").show();
                        }
                    }
                    // $("#preview2").attr("src", "storage/" + response.blog.blog_image);
                    // $("#preview2").show();
                    $("#update-blog").attr("action", `blogs/${id}/update`);
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
                url: `blogs/${id}/update`,
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
                data: new FormData($("#update-blog")[0]),
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
                        if (response.blog.blog_image == null) {
                            img = "No Image";
                        } else {
                            if (response.blog.blog_image.startsWith('uploads')) {
                                img =
                                    `<img src="storage/${response.blog.blog_image}" alt="" class="tw-w-16 tw-h-16">`;
                            } else {
                                img =
                                    `<img src="${response.blog.blog_image}" alt="" class="tw-w-16 tw-h-16">`;
                            }
                        }

                        $("#index_" + id).html(
                            `
                    <td>
                        ${img}
                        </td>
                    <td>${response.blog.title}</td>
                   
                    <td class="tw-text-nowrap">
                        <a href="/blogs/${response.blog.slug}" class="btn btn-sm btn-info me-2">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="${response.blog.id}" id="btn-edit"
                            class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="javascript:void(0)" data-id="${response.blog.id}" id="btn-delete"
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
