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
    <section id="content-types">
        <div class="page-content">
            <h3 class="tw-text-3xl tw-font-semibold tw-text-center tw-py-4">Our Products</h3>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <a href="/product/{{ $product->id }}">
                            <div class="card hover:tw-scale-105 tw-transition-all tw-delay-100">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $product->category->category_name }}</h4>
                                    </div>
                                    <img class="img-fluid w-100" src="{{ asset('/static/images/samples/banana.jpg') }}"
                                        alt="Card image cap">
                                </div>
                        </a>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-8">
                                    <a href="/product/{{ $product->id }}" class="text-decoration-none ">
                                        <p class="tw-text-sm">{{ $product->product_name }}</p>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <p class="tw-text-sm">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @auth
                                        <button class="button tw-w-full rounded mt-2" data-user="true"
                                            data-product="{{ $product->id }}">
                                            <span>Add to cart</span>
                                            <div class="cart">
                                                <svg viewBox="0 0 36 26">
                                                    <polyline points="1 2.5 6 2.5 10 18.5 25.5 18.5 28.5 7.5 7.5 7.5">
                                                    </polyline>
                                                    <polyline points="15 13.5 17 15.5 22 10.5"></polyline>
                                                </svg>
                                            </div>
                                        </button>
                                    @else
                                        <button class="button tw-w-full rounded mt-2" data-user="false"
                                            data-product="{{ $product->id }}">
                                            <span>Add to cart</span>
                                            <div class="cart">
                                                <svg viewBox="0 0 36 26">
                                                    <polyline points="1 2.5 6 2.5 10 18.5 25.5 18.5 28.5 7.5 7.5 7.5">
                                                    </polyline>
                                                    <polyline points="15 13.5 17 15.5 22 10.5"></polyline>
                                                </svg>
                                            </div>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            @endforeach
        </div>

        </div>
    </section>

    @include('layouts.loader')
@endsection

@section('css')
    <style>
        .button {
            --background: #362A89;
            --text: #fff;
            --cart: #fff;
            --tick: var(--background);
            position: relative;
            border: none;
            background: none;
            padding: 8px 28px;
            border-radius: 8px;
            -webkit-appearance: none;
            -webkit-tap-highlight-color: transparent;
            -webkit-mask-image: -webkit-radial-gradient(white, black);
            overflow: hidden;
            cursor: pointer;
            text-align: center;
            min-width: 144px;
            color: var(--text);
            background: var(--background);
            transform: scale(var(--scale, 1));
            transition: transform .4s cubic-bezier(.36, 1.01, .32, 1.27);

            &:active {
                --scale: .95;
            }

            span {
                font-size: 14px;
                font-weight: 500;
                display: block;
                position: relative;
                padding-left: 24px;
                margin-left: -8px;
                line-height: 26px;
                transform: translateY(var(--span-y, 0));
                transition: transform .7s ease;

                &:before,
                &:after {
                    content: '';
                    width: var(--w, 2px);
                    height: var(--h, 14px);
                    border-radius: 1px;
                    position: absolute;
                    left: var(--l, 8px);
                    top: var(--t, 6px);
                    background: currentColor;
                    transform: scale(.75) rotate(var(--icon-r, 0deg)) translateY(var(--icon-y, 0));
                    transition: transform .65s ease .05s;
                }

                &:after {
                    --w: 14px;
                    --h: 2px;
                    --l: 2px;
                    --t: 12px;
                }
            }

            .cart {
                position: absolute;
                left: 50%;
                top: 50%;
                margin: -13px 0 0 -18px;
                transform-origin: 12px 23px;
                transform: translateX(-120px) rotate(-18deg);

                &:before,
                &:after {
                    content: '';
                    position: absolute;
                }

                &:before {
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                    box-shadow: inset 0 0 0 2px var(--cart);
                    bottom: 0;
                    left: 9px;
                    filter: drop-shadow(11px 0 0 var(--cart));
                }

                &:after {
                    width: 16px;
                    height: 9px;
                    background: var(--cart);
                    left: 9px;
                    bottom: 7px;
                    transform-origin: 50% 100%;
                    transform: perspective(4px) rotateX(-6deg) scaleY(var(--fill, 0));
                    transition: transform 1.2s ease var(--fill-d);
                }

                svg {
                    z-index: 1;
                    width: 36px;
                    height: 26px;
                    display: block;
                    position: relative;
                    fill: none;
                    stroke: var(--cart);
                    stroke-width: 2px;
                    stroke-linecap: round;
                    stroke-linejoin: round;

                    polyline {
                        &:last-child {
                            stroke: var(--tick);
                            stroke-dasharray: 10px;
                            stroke-dashoffset: var(--offset, 10px);
                            transition: stroke-dashoffset .4s ease var(--offset-d);
                        }
                    }
                }
            }

            &.loading {
                --scale: .95;
                --span-y: -32px;
                --icon-r: 180deg;
                --fill: 1;
                --fill-d: .8s;
                --offset: 0;
                --offset-d: 1.73s;

                .cart {
                    animation: cart 3.4s linear forwards .2s;
                }
            }
        }

        @keyframes cart {
            12.5% {
                transform: translateX(-60px) rotate(-18deg);
            }

            25%,
            45%,
            55%,
            75% {
                transform: none;
            }

            50% {
                transform: scale(.9);
            }

            44%,
            56% {
                transform-origin: 12px 23px;
            }

            45%,
            55% {
                transform-origin: 50% 50%;
            }

            87.5% {
                transform: translateX(70px) rotate(-18deg);
            }

            100% {
                transform: translateX(140px) rotate(-18deg);
            }
        }

        html {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        * {
            box-sizing: inherit;

            &:before,
            &:after {
                box-sizing: inherit;
            }
        }
    </style>
@endsection
@section('js')
    <script>
        $("#loader").hide();
        buttons = document.querySelectorAll('.button');
        buttons.forEach(button => button.addEventListener('click', e => {
            if (!button.classList.contains('loading')) {
                $("#loader").show();

                button.classList.add('loading');
                if (button.getAttribute('data-user') == 'true') {
                    let product_id = button.getAttribute('data-product');

                    let token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        url: `/add-to-cart`,
                        type: "POST",
                        cache: false,
                        data: {
                            "change": "add to cart",
                            "product_id": product_id,
                            "_token": token
                        },
                        error: function(error) {
                            $("#loader").hide();
                            console.log(error);
                        },
                        success: function(response) {
                            $("#loader").hide();
                            $("#cartCount").text(response.cartCount);
                            Swal.fire({
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        },

                    })
                } else {
                    $("#loader").hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... You are not logged in!',
                        text: 'Please login to continue',
                        showConfirmButton: true,
                        confirmButtonText: 'Login',
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',

                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/login';
                        }
                    });
                }
                setTimeout(() => button.classList.remove('loading'), 3700);


            }
            e.preventDefault();
        }));
    </script>

    {{-- <script>
        $("#loader").hide();
        $('#login-form').submit(function(e) {
            e.preventDefault();
            $("#loader").show();

            //define variable
            let email = $('#email').val();
            let password = $('#password').val();
            let token = $("meta[name='csrf-token']").attr("content");

            // console.table(email, password, token);

            //ajax
            $.ajax({
                url: `/login`,
                type: "POST",
                cache: false,
                data: {
                    "email": email,
                    "password": password,
                    "_token": token
                },
                success: function(response) {
                    $("#loader").hide();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: `${response.message}`,
                            text: `${response.name}`,
                            showConfirmButton: false,
                            timer: 2000
                        });

                        //redirect
                        setTimeout(() => {
                            window.location.href = '/';
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `${response.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },

                error: function(error) {
                    console.log(error);
                }

            });

        });
    </script> --}}
@endsection
