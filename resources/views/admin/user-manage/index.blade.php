@extends('layouts.app', ['title' => 'User'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">User</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                User
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="page-content">
                <div class="d-flex mt-4 justify-content-between">
                    <a href="/users/deleted" class="btn btn-danger mb-3"><i class="bi bi-trash"></i>
                        Deleted User
                    </a>
                    <a href="javascript:void(0)" id="btn-add" class="btn btn-primary mb-3"><i class="bi bi-plus-lg"></i>
                        Add New User
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @foreach ($users as $user)
                                    <tr id="index_{{ $user->id }}">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->role }}</td>

                                        <td class="tw-text-nowrap">
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                                                data-id="{{ $user->id }}" id="btn-delete">
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
    @include('layouts.modal.modal-admin-user')

    <div id="basic" class="!tw-hidden"></div>
    <div id="basic-edit" class="!tw-hidden"></div>
@endsection

@section('js')
    <script>
        $("#loader").hide();
        $("#btn-add").click(function() {
            $("#name").val("");
            $("#email").val("");
            $("#phone").val("");
            $("#address").val("");
            $("#role").val("");
            $("#password").val("");
            $("#tambahModal").modal("show");

        });
        $("#btn-submit").click(function() {
            let name = $("#name").val();
            let email = $("#email").val();
            let phone = $("#phone").val();
            let address = $("#address").val();
            let role = $("#role").val();
            let password = $("#password").val();
            let token = $("meta[name='csrf-token']").attr("content");
            $("#tambahModal").modal("hide");
            $("#loader").show();
            $.ajax({
                url: "/users/create",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    address: address,
                    role: role,
                    password: password,
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
                    <tr id="index_${response.user.id}">
                        <td>${response.user.name}</td>
                        <td>${response.user.email}</td>
                        <td>${response.user.phone ?? ''}</td>
                        <td>${response.user.address ?? ''}</td>
                        <td>${response.user.role}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-id="${response.user.id}" id="btn-delete">
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
                        text: 'Failed to create user.',
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
                        url: `users/${id}`,
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
