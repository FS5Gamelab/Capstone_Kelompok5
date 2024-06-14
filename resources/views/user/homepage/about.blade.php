@extends('layouts.app-user', ['title' => 'About Us'])
@section('main-content')
    <!-- Start About Us Section -->
    <div class="about-us-section">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <h4 class="section-title ">About Us</h4>
                    <h1 class="mb-4 my-4"> <i> " We Bake Every Item From The Core Of Our Hearts "</i></h1>
                    <p>Selera Negari adalah restoran keluarga yang menawarkan berbagai macam makanan dan minuman seperti
                        Gado-Gado Nusantara ,Sate Ayam Madura , Tahu Isi Goreng , Mendoan, Nasi Goreng Spesial, dan masih
                        banyak menu lainnya. Selera Negari restoran berusaha memberikan tempat yang nyaman untuk berkumpul
                        bagi para customernya karena Selera Negari, Your Culinary Journey.</p>

                    <div class="row my-4">
                        <div class="col-6 col-md-6 mb-4">
                            <div class="feature">
                                <div class="icon">
                                    <i class="fas fa-share text-primary me-2"></i>Fresh and Fast food Delivery
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <i class="fas fa-share text-primary me-2"></i>24/7 Customer Support
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <i class="fas fa-share text-primary me-2"></i>Easy Customization Options
                                </div>

                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <i class="fas fa-share text-primary me-2"></i>Delicious Deals for Delicious Meals
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap">
                        <img src="{{ asset('static/images/samples/sate.png') }}" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Us Section -->

    {{-- Start Our Team Section --}}
    <div class="container-fluid team mb-5 " style="margin-top: 100px">
        <div class="container">
            <div class="text-center ">
                <small
                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Our
                    Team</small>
                <h1 class="mb-5">The Best Chef In Town</h1>
            </div>

            <div class="row g-4 justify-content-center">
                <div class=" col-lg-2 col-md-4 ">
                    <div class="team-item rounded">
                        <img class="img-fluid rounded-top " src="{{ asset('static/images/faces/1.jpg') }}" alt="">
                        <div class="team-content text-center py-3 bg-dark rounded-bottom">
                            <h4 class="text-primary">Susi</h4>
                            <p class="text-white mb-2">Decoration Chef</p>
                            <div class="team-icon">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-2 col-md-4 ">
                    <div class="team-item rounded">
                        <img class="img-fluid rounded-top " src="{{ asset('static/images/faces/2.jpg') }}" alt="">
                        <div class="team-content text-center py-3 bg-dark rounded-bottom">
                            <h4 class="text-primary">Henry</h4>
                            <p class="text-white mb-2">Executive Chef</p>
                            <div class="team-icon">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-2 col-md-4 ">
                    <div class="team-item rounded">
                        <img class="img-fluid rounded-top " src="{{ asset('static/images/faces/3.jpg') }}" alt="">
                        <div class="team-content text-center py-3 bg-dark rounded-bottom">
                            <h4 class="text-primary">Yanti</h4>
                            <p class="text-white mb-2">Kitchen Porter</p>
                            <div class="team-icon">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-2 col-md-4 ">
                    <div class="team-item rounded">
                        <img class="img-fluid rounded-top " src="{{ asset('static/images/faces/4.jpg') }}" alt="">
                        <div class="team-content text-center py-3 bg-dark rounded-bottom">
                            <h4 class="text-primary">Tono</h4>
                            <p class="text-white mb-2">Head Chef</p>
                            <div class="team-icon">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-2 col-md-4 ">
                    <div class="team-item rounded">
                        <img class="img-fluid rounded-top " src="{{ asset('static/images/faces/5.jpg') }}"
                            alt="">
                        <div class="team-content text-center py-3 bg-dark rounded-bottom">
                            <h4 class="text-primary">Laila</h4>
                            <p class="text-white mb-2">Decoration Chef</p>
                            <div class="team-icon">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i
                                        class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- End Our Team Section --}}

    {{-- Start Contact Us Section --}}
    <div class="container-fluid contact mb-5 " style="margin-top: 100px">
        <div class="container">
            <div class="text-center ">
                <h1 class="mb-5">Contact Us</h1>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 ">
                    <div class="d-inline-flex w-100 border border-primary p-4 rounded mb-4">
                        <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                        <div class="">
                            <h4>Address</h4>
                            <p>123 Street, Jakarta, IND</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 ">
                    <div class="d-inline-flex w-100 border border-primary p-4 rounded mb-4">
                        <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                        <div class="">
                            <h4>Mail Us</h4>
                            <p>seleranegeri@contact.us</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 ">
                    <div class="d-inline-flex w-100 border border-primary p-4 rounded mb-4">
                        <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                        <div class="">
                            <h4>Telephone</h4>
                            <p>001 (313) 324 567</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Contact Us Section --}}

    @include('layouts.hide')
@endsection
