@extends('layouts.app', ['title' => 'Category'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">All Category</h3>
                    {{-- <p class="text-subtitle text-muted">The default layout.</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Category
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="page-content">
                <div class="d-flex mt-4 justify-content-between">
                    <a href="/categories/deleted" class="btn btn-danger mb-3"><i class="bi bi-trash"></i>
                        Deleted Category
                    </a>
                    <a href="javascript:void(0)" id="btn-add" class="btn btn-primary mb-3"><i class="bi bi-plus-lg"></i>
                        Add New Category
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Created/Updated By</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @foreach ($categories as $category)
                                    <tr id="index_{{ $category->id }}">
                                        <td>{{ $category->category_name }}</td>
                                        <td>
                                            @if ($category->user)
                                                {{ $category->user->name }} ({{ $category->user->role }})
                                            @else
                                                <i class="tw-text-xs">User Deleted</i>
                                            @endif
                                        </td>
                                        <td class="tw-text-nowrap">
                                            <a href="javascript:void(0)" data-id="{{ $category->id }}" id="btn-edit"
                                                class="btn btn-sm btn-primary me-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-id="{{ $category->id }}" id="btn-delete"
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
    @include('layouts.modal.modal-category')

    <div id="basic" class="!tw-hidden"></div>
    <div id="basic-edit" class="!tw-hidden"></div>
@endsection

@section('js')
    <script>
        $("#loader").hide();
        $("#btn-add").click(function() {
            $("#n-category_name").val("");
            $("#tambahModal").modal("show");

        });
        $("#btn-submit").click(function() {
            let name = $("#n-category_name").val();
            let token = $("meta[name='csrf-token']").attr("content");
            $("#tambahModal").modal("hide");
            $("#loader").show();
            $.ajax({
                url: "/categories/create",
                type: "POST",
                data: {
                    category_name: name,
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
                        let newRow = `
                    <tr id="index_${response.category.id}">
                        <td>${response.category.category_name}</td>
                        <td>${response.user.name} (${ response.user.role })</td>
                        <td>
                            <a href="javascript:void(0)" data-id="${response.category.id}" id="btn-edit"
                                                class="btn btn-sm btn-primary me-2">
                                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-id="${response.category.id}" id="btn-delete">
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
                        text: 'Failed to create category.',
                        showConfirmButton: true,
                    });
                }
            });
        });

        $(document).on("click", "#btn-edit", function() {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
            $("#loader").show();
            $.ajax({
                url: `categories/edit/${id}`,
                type: "GET",
                success: function(response) {
                    $("#loader").hide();
                    $("#id").val(response.category.id);
                    $("#category_name").val(response.category.category_name);
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

        $(document).on("click", "#btn-update", function() {
            let id = $("#id").val();
            let name = $("#category_name").val();
            let token = $("meta[name='csrf-token']").attr("content");
            $("#ubahModal").modal("hide");
            $("#loader").show();
            $.ajax({
                url: `categories/update/${id}`,
                type: "PUT",
                data: {
                    category_name: name,
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
                        $("#index_" + id).html(`
                    <td>${response.category.category_name}</td>
                    <td>${response.user.name} (${ response.user.role })</td>
                    <td>
                        <a href="javascript:void(0)" data-id="${response.category.id}" id="btn-edit"
                                            class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-id="${response.category.id}" id="btn-delete">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                    `);
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
                        text: 'Failed to update category.',
                        showConfirmButton: true,
                    });
                }
            });
        });


        $(document).on("click", "#btn-delete", function() {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
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
                        url: `categories/${id}`,
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
                        }
                    })
                }
            })
        })
    </script>
@endsection
