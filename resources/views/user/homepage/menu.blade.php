@extends('layouts.app-user', ['title' => 'Menu'])

@section('main-content')
    <section id="content-types">
        <div class="page-content">
            <h3 class="tw-text-3xl tw-font-semibold tw-text-center tw-py-4">Our Products</h3>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <a href="/product/{{ $product->slug }}">
                            <div class="card hover:tw-scale-105 tw-transition-all tw-delay-100">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title !tw-text-lg">
                                            @if ($product->category)
                                                {{ $product->category->category_name }}
                                            @else
                                                {{ $product->product_name }}
                                            @endif
                                        </h4>
                                    </div>
                                    @if ($product->product_image)
                                        @if (Str::startsWith($product->product_image, 'uploads/'))
                                            <img src="{{ asset('storage/' . $product->product_image) }}"
                                                class="img-fluid rounded-start !tw-h-60 !tw-w-full"
                                                alt="{{ $product->product_image }}">
                                        @else
                                            <img src="{{ asset($product->product_image) }}"
                                                class="img-fluid rounded-start !tw-h-60 !tw-w-full"
                                                alt="{{ $product->product_image }}">
                                        @endif
                                    @else
                                        <img class="img-fluid tw-w-full !tw-h-60"
                                            src="{{ asset('/static/images/samples/1.png') }}" alt="Card image cap">
                                    @endif
                                </div>
                        </a>
                        <div class="card-footer">
                            <div class="row mb-2">
                                <div class=" col-md-12 ">
                                    <span class="!tw-text-xs !tw-bg-gray-400 !tw-bg-opacity-80 badge">
                                        @if ($product->rating == 0)
                                            0
                                        @elseif ($product->rating == 5)
                                            5
                                        @else
                                            {{ $product->rating }}
                                        @endif
                                        / 5
                                        <i class="bi bi-star-fill tw-text-yellow-500"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <a href="/product/{{ $product->slug }}" class="text-decoration-none ">
                                        <p class="tw-text-sm">{{ $product->product_name }}</p>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <p class="tw-text-sm">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if (!Auth::user() || Auth::user()->role == 'user')
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($product->stock > 0)
                                            @auth
                                                <button class="button-stock tw-w-full rounded mt-2" data-user="true"
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
                                                <button class="button-stock tw-w-full rounded mt-2" data-user="false"
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
                                        @else
                                            <button class="button tw-w-full rounded mt-2">
                                                <span>Out of Stock</span>
                                                <div class="cart">
                                                    <svg viewBox="0 0 36 26">
                                                        <polyline points="1 2.5 6 2.5 10 18.5 25.5 18.5 28.5 7.5 7.5 7.5">
                                                        </polyline>
                                                        <polyline points="15 13.5 17 15.5 22 10.5"></polyline>
                                                    </svg>
                                                </div>
                                            </button>
                                        @endif

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

            </div>
            @endforeach
        </div>

        </div>
    </section>

    @include('layouts.loader')
    @include('layouts.hide')
@endsection
@section('css')
    <style>
        .button-stock {
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

        .button {
            --background: #58575e;
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
            cursor: not-allowed;
            text-align: center;
            min-width: 144px;
            color: var(--text);
            background: var(--background);

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
        }
    </style>
@endsection
@section('js')
    <script>
        $("#loader").hide();
        buttons = document.querySelectorAll('.button-stock');
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

                        },
                        success: function(response) {
                            $("#loader").hide();
                            if (response.success) {
                                $("#cartCount").text(response.cartCount);
                                Swal.fire({
                                    icon: 'success',
                                    title: `${response.message}`,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: `${response.message}`,
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                })
                            }
                        },

                    })
                } else {
                    $("#loader").hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `You need to login first.`,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
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
@endsection
