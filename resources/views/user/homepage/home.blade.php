@extends('layouts.app-user', ['title' => 'Homepage'])
@section('main-content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-4 align-items-center g-5">
                <div class="col-md-6">
                    <h1 class="h1">Makan dan Nikmati Keajaiban Kuliner di Restoran Kami</h1>
                    <p>Selamat datang di Restoran Kami! Nikmati hidangan lezat, pelayanan ramah, dan suasana nyaman untuk
                        pengalaman kuliner yang tak terlupakan.</p>
                    <a href="./reservation" class="btn btn-light">
                        Booking Sekarang
                    </a>
                    <div class="col-12 mt-4 row">
                        <div class="col-auto">
                            <div class="avatar avatar-lg me-3">
                                <img src="{{ asset('/static/images/faces/1.jpg') }}" alt="" srcset="">
                            </div>
                            <div class="avatar avatar-lg -tw-ms-8">
                                <img src="{{ asset('/static/images/faces/2.jpg') }}" alt="" srcset="">
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
                    <img class="img-fluid rounded" src="{{ asset('static/images/samples/sate.png') }}" alt=""
                        id="gambar">
                </div>
                <div class="col-md-12">
                    <h2 class="h2 text-center mb-4">Layanan Kami</h2>
                    <div class="row justify-content-center g-3">
                        <div class="col-md-3">
                            <div class="card px-3 pt-3 hover:tw-scale-105" style="height:100%">
                                <img src="{{ asset('static/images/illustration/4.svg') }}" alt="">
                                <h4 class="h4 text-center mt-3">Pelayanan Berkualitas</h4>
                                <p class="text-center">Nikmati layanan terbaik dari staf kami yang ramah dan profesional.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card px-3 pt-3 hover:tw-scale-105" style="height:100%">
                                <img src="{{ asset('static/images/illustration/1.svg') }}" alt="">
                                <h4 class="h4 text-center mt-3">Pesan Kapanpun</h4>
                                <p class="text-center">Dengan layanan online, Anda bisa memesan makanan favorit kapan saja
                                    dan di mana saja.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card px-3 pt-3 hover:tw-scale-105" style="height:100%">
                                <img src="{{ asset('static/images/illustration/2.svg') }}" alt="">
                                <h4 class="h4 text-center mt-3">Lacak Pesanan Anda</h4>
                                <p class="text-center">Pantau status pesanan Anda secara real-time dan ketahui waktu
                                    kedatangan.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card px-3 pt-3 hover:tw-scale-105" style="height:100%">
                                <img src="{{ asset('static/images/illustration/3.svg') }}" alt="">
                                <h4 class="h4 text-center mt-3">Booking Tempat</h4>
                                <p class="text-center">Reservasi tempat online untuk memastikan meja terbaik di restoran
                                    kami.</p>
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
                                    <div class="col-sm-8 d-flex flex-column justify-content-center text-white">
                                        <h2 class="h2 text-white">Diskon 20% untuk Pelanggan Baru</h2>
                                        <p>Dapatkan diskon 20% untuk kunjungan pertama Anda ke restoran kami. Berlaku hingga
                                            akhir bulan ini.</p>
                                        <a href="/menu" class="btn bg-white text-primary fw-medium mt-4 px-5"
                                            style="width: fit-content">Lihat Menu</a>
                                    </div>
                                    <div class="col-sm-4">
                                        <img src="{{ asset('static/images/illustration/6.svg') }}"
                                            class="img-fluid rounded mb-3" alt="Gallery Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card p-2 py-4 p-sm-5">
                        <h2 class="h2 text-center mb-3">Customer Review</h2>
                        @if ($review)
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="p-2 border rounded">
                                        @if ($review->product->product_image)
                                            @if (Str::startsWith($review->product->product_image, 'uploads/'))
                                                <img src="{{ asset('storage/' . $review->product->product_image) }}"
                                                    class="img-fluid rounded" alt="{{ $review->product->product_image }}">
                                            @else
                                                <img src="{{ asset($review->product->product_image) }}"
                                                    class="img-fluid rounded" alt="{{ $review->product->product_image }}">
                                            @endif
                                        @else
                                            <img class="rounded" src="{{ asset('static/images/samples/sate.png') }}"
                                                alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8 d-flex">
                                    <div class="border p-3 rounded w-100">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar avatar-lg me-3">
                                                @if ($review->user->profile_image)
                                                    <img src="{{ asset('storage/' . $review->user->profile_image) }}"
                                                        alt="">
                                                @else
                                                    <img src="{{ asset('/static/images/faces/1.jpg') }}" alt=""
                                                        srcset="">
                                                @endif
                                            </div>
                                            <div>
                                                <h5 class="h5 mb-0">{{ $review->user->name }}</h5>
                                                <div>
                                                    @for ($i = 0; $i < $review->rating; $i++)
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @endfor
                                                    @if ($review->rating < 5)
                                                        @for ($i = 1; $i <= 5 - $review->rating; $i++)
                                                            <i class="bi bi-star-fill text-dark"></i>
                                                        @endfor
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <p class="border-top pt-2">
                                            "{{ $review->comment }}"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center">Belum ada review</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('layouts.hide')

@endsection
