@extends('layouts.app', ['title' => 'Deleted Category'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">Deleted Category</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/categories">Category</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Deleted Category
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
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm me-1"
                                                data-id="{{ $category->id }}" id="btn-restore">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                                                data-id="{{ $category->id }}" id="btn-delete">
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
                        url: `/categories/force-delete/${id}`,
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
                        url: `/categories/restore/${id}`,
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
