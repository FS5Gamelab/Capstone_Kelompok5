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
                <div class="col-md-12">
                    <h2 class="h2 text-center mb-4">Layanan Kami</h2>
                    <div class="row justify-content-center g-3">
                        <div class="col-md-3">
                            <div class="card px-3 pt-3 hover:tw-scale-105" style="height:100%">
                                <img src="{{ asset('static/images/illustration/4.svg')}}" alt="">
                                <h4 class="h4 text-center mt-3">Pelayanan Berkualitas</h4>
                                <p class="text-center">Nikmati layanan terbaik dari staf kami yang ramah dan profesional.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card px-3 pt-3 hover:tw-scale-105" style="height:100%">
                                <img src="{{ asset('static/images/illustration/1.svg')}}" alt="">
                                <h4 class="h4 text-center mt-3">Pesan Kapanpun</h4>
                                <p class="text-center">Dengan layanan online, Anda bisa memesan makanan favorit kapan saja dan di mana saja.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card px-3 pt-3 hover:tw-scale-105" style="height:100%">
                                <img src="{{ asset('static/images/illustration/2.svg')}}" alt="">
                                <h4 class="h4 text-center mt-3">Lacak Pesanan Anda</h4>
                                <p class="text-center">Pantau status pesanan Anda secara real-time dan ketahui waktu kedatangan.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card px-3 pt-3 hover:tw-scale-105" style="height:100%">
                                <img src="{{ asset('static/images/illustration/3.svg')}}" alt="">
                                <h4 class="h4 text-center mt-3">Booking Tempat</h4>
                                <p class="text-center">Reservasi tempat online untuk memastikan meja terbaik di restoran kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="promotions col-md-12 ">
                    <h2 class="h2 text-center mb-4">Promo Spesial</h2>
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="bg-primary rounded p-4 px-5">
                                <div class="row">
                                <div class="col-8 d-flex flex-column justify-content-center text-white">
                                    <h2 class="h2 text-white">Diskon 20% untuk Pelanggan Baru</h2>
                                    <p>Dapatkan diskon 20% untuk kunjungan pertama Anda ke restoran kami. Berlaku hingga akhir bulan ini.</p>
                                </div>
                                <div class="col-4">
                                    <img src="{{ asset('static/images/illustration/6.svg') }}" class="img-fluid rounded mb-3" alt="Gallery Image" >
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery mt-5 col-md-12">
                    <h2 class="h2 text-center mb-4">Galeri Foto</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('static/images/samples/1.png') }}" class="img-fluid rounded mb-3" alt="Gallery Image">
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset('static/images/samples/2.png') }}" class="img-fluid rounded mb-3" alt="Gallery Image">
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset('static/images/samples/3.png') }}" class="img-fluid rounded mb-3" alt="Gallery Image">
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset('static/images/samples/4.png') }}" class="img-fluid rounded mb-3" alt="Gallery Image">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
@endsection
