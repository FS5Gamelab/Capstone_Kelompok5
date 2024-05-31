@extends('layouts.app-user', ['title' => 'Homepage'])
@section('main-content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-4 align-items-center g-5">
                <div class="col-md-6">
                    <h1 class="h1">Makan dan Nikmati Keajaiban Kuliner di Restoran Kami</h1>
                    <p>Selamat datang di Restoran Kami! Nikmati hidangan lezat, pelayanan ramah, dan suasana nyaman untuk pengalaman kuliner yang tak terlupakan.</p>
                    <a href="./reservation" class="btn btn-light">
                        Booking Sekarang
                    </a>
                    <div class="col-12 mt-4 row">
                        <div class="col-auto">
                            <div class="avatar avatar-lg me-3">
                                <img src="{{ asset('/static/images/faces/1.jpg') }}" alt=""
                                    srcset="">
                            </div>
                            <div class="avatar avatar-lg -tw-ms-8">
                                <img src="{{ asset('/static/images/faces/2.jpg') }}" alt=""
                                srcset="">
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <span> 35k+ Well Reviews</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid rounded" src="{{ asset('static/images/samples/sate.png') }}" alt="" id="gambar">
                </div>
            </div>
        </div>
    </div>
@endsection
