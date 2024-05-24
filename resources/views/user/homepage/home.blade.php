@extends('layouts.app-user', ['title' => 'Homepage'])
@section('main-content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="fs-1">Eat And Enjoy In Our Restaurant</h1>
                            <p>Award Winning Seafood And Where Everyone Wants To Be.</p>
                            <p>The Freshest Fish, Succulent Fish</p>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="row d-flex justify-content-center align-items-center ">
                                <div class="col-md-6 mb-4">
                                    <img class="img-fluid" src="{{ asset('static/images/samples/1.png') }}" alt="">
                                </div>
                                <div class="col-md-6 d-flex justify-content-center">
                                    <div class="row text-center">
                                        <div class="col-md-12 tw-mb-5 sm:tw-mb-7">
                                            <a href="/menu" class="p-2 tw-bg-black tw-text-white tw-rounded">
                                                Explore Menu
                                            </a>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-8 col-lg-6">
                                                    <div class="avatar avatar-lg me-3">
                                                        <img src="{{ asset('/static/images/faces/1.jpg') }}" alt=""
                                                            srcset="">
                                                    </div>
                                                    <div class="avatar avatar-lg -tw-ms-8">
                                                        <img src="{{ asset('/static/images/faces/2.jpg') }}" alt=""
                                                            srcset="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-6">
                                                    <span> 35k+ Well Reviews</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <img src="{{ asset('/static/images/samples/4.png') }}" alt="" class="img-fluid ">
                </div>
            </div>
        </div>
    </div>
@endsection
