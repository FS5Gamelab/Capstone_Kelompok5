@extends('layouts.app-user', ['title' => $product->product_name])

@section('main-content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $product->product_name }}</h4>
            </div>
            <div class="card-body">
                <div class="tw-w-full">
                    @if (Str::startsWith($product->product_image, 'uploads/'))
                        <img src="{{ asset('storage/' . $product->product_image) }}" class="img-fluid rounded !tw-w-full"
                            alt="{{ $product->product_image }}">
                    @else
                        <img src="{{ asset($product->product_image) }}" class="img-fluid rounded !tw-w-full"
                            alt="{{ $product->product_image }}">
                    @endif
                </div>
                <div class="tw-flex tw-justify-between tw-mt-4">
                    <div class="tw-w-1/3">
                        <label class="form-label">Category</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200 text-capitalize">
                            {{ $product->category->category_name }}</p>
                    </div>
                    <div class="tw-w-1/3">
                        <label class="form-label">Type</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200 text-capitalize">{{ $product->type }}</p>
                    </div>
                    <div class="tw-w-1/3">
                        <label class="form-label">Rating</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200">
                            @if ($product->rating == 0)
                                0
                            @elseif ($product->rating == 5)
                                5
                            @else
                                {{ $product->rating }}
                            @endif
                            / 5

                            <i class="bi bi-star-fill !tw-text-yellow-500" style="color: yellow;"></i>
                        </p>
                    </div>
                </div>
                <div class="tw-flex tw-mt-4">
                    <div class="tw-w-full">
                        <label class="form-label">Description</label>
                        <p class="tw-text-gray-700 dark:tw-text-gray-200">{{ $product->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="review-section">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Reviews</h4>
                <div class="table-responsive">
                    <table class="table table-borderless" id="table1">
                        <thead>
                            <tr>
                                <th data-sortable="false">User</th>
                                <th data-sortable="false">Comment</th>
                                <th>Rating</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->reviews as $review)
                                <tr>
                                    <td>{{ $review->user->name }}</td>

                                    <td class="comment-column">
                                        <p>
                                            {{ $review->comment }}
                                        </p>
                                    </td>
                                    <td>
                                        @for ($i = 0; $i < $review->rating; $i++)
                                            <i class="bi bi-star-fill tw-text-yellow-500"></i>
                                        @endfor
                                        @if ($review->rating < 5)
                                            @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                <i class="bi bi-star tw-text-gray-800"></i>
                                            @endfor
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @if (!Auth::user() || Auth::user()->role == 'user')
        <section class="py-4">
            <hr>
        </section>

        <section class="add-to-cart section tw-fixed tw-bottom-0 tw-left-0 tw-right-0 tw-z-50">
            <div
                class="row tw-flex tw-items-center md:tw-px-0 !tw-pl-4 !tw-pr-4 md:!tw-pl-16 md:!tw-pr-11 py-3 tw-bg-gray-800">
                <div class="col-8 !tw-text-sm md:!tw-text-2xl tw-font-bold tw-text-start">
                    Price :
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="col-4">
                    @auth
                        <button class="button tw-w-full rounded mt-2" data-user="true" data-product="{{ $product->id }}">
                            <span>
                                Cart
                            </span>
                            <div class="cart">
                                <svg viewBox="0 0 36 26">
                                    <polyline points="1 2.5 6 2.5 10 18.5 25.5 18.5 28.5 7.5 7.5 7.5">
                                    </polyline>
                                    <polyline points="15 13.5 17 15.5 22 10.5"></polyline>
                                </svg>
                            </div>
                        </button>
                    @else
                        <button class="button tw-w-full rounded mt-2" data-user="false" data-product="{{ $product->id }}">
                            <span>Cart</span>
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
        </section>
    @endif

    <div id="basic" class="!tw-hidden"></div>
    <div id="basic-edit" class="!tw-hidden"></div>
@endsection
@section('css')
    <style>
        .comment-column p {
            max-width: 300px;
            /* Tentukan lebar maksimum yang sesuai */
            word-wrap: break-word;
            /* Untuk IE */
            word-break: break-word;
            /* Untuk browser modern */
        }

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
    @if (!Auth::user() || Auth::user()->role == 'user')
        <script>
            $("#footer").hide();
        </script>
    @endif
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
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '/profile';
                                    }
                                });
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
@endSection
