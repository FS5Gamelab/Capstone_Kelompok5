@extends('layouts.app', ['title' => 'Dashboard'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">Dashboard</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start align-items-center">
                                                <div
                                                    class="mb-2 tw-bg-purple-500 tw-text-white rounded tw-p-2 tw-size-12 tw-flex tw-justify-center">
                                                    <i class="bi bi-people"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Users</h6>
                                                <h6 class="font-extrabold mb-0">{{ $userCount }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start align-items-center">
                                                <div
                                                    class="mb-2 tw-bg-blue-500 tw-text-white rounded tw-p-2 tw-size-12 tw-flex tw-justify-center">
                                                    <i class="bi bi-shop"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Products</h6>
                                                <h6 class="font-extrabold mb-0">{{ $productCount }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start align-items-center">
                                                <div
                                                    class="mb-2 tw-bg-green-500 tw-text-white rounded tw-p-2 tw-size-12 tw-flex tw-justify-center">
                                                    <i class="bi bi-cart-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Orders</h6>
                                                <h6 class="font-extrabold mb-0">{{ $orderCount }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start align-items-center">
                                                <div
                                                    class="mb-2 tw-bg-red-400 tw-text-white rounded tw-p-2 tw-size-12 tw-flex tw-justify-center">
                                                    <i class="bi bi-calendar-event"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Reservations</h6>
                                                <h6 class="font-extrabold mb-0">{{ $reservationCount }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Success Orders Recapitulation</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-orders"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row tw-flex tw-justify-between">
                                    <div class="col-8">
                                        <h6 class="card-title">Reservation Timeline</h6>
                                    </div>
                                    <div class="col-4">
                                        <select name="date" id="date" class="form-select form-control">
                                            <option value="today">Today</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="tomorrow">Tomorrow</option>
                                            <option value="3-days-later">3 days later</option>
                                            <option value="1-week-later">1 week later</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="content">
                                    <ul class="timeline" id="timeline">
                                        @if ($reservations->count() == 0)
                                            <p>No reservation today</p>
                                        @else
                                            @foreach ($reservations as $reservation)
                                                <li class="event"
                                                    data-date="{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}">
                                                    <h5 class="!tw-text-lg !tw-font-semibold" id="name">
                                                        {{ $reservation->name }}</h5>
                                                    <p>
                                                        <small>{{ $reservation->phone }}</small>
                                                    </p>
                                                    <p>
                                                        <small>{{ $reservation->people }} people</small>
                                                    </p>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-12 col-xl-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Profile Visit</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <svg class="bi text-primary" width="32" height="32"
                                                        fill="blue" style="width:10px">
                                                        <use
                                                            xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
                                                    </svg>
                                                    <h5 class="mb-0 ms-3">Europe</h5>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="mb-0">862</h5>
                                            </div>
                                            <div class="col-12">
                                                <div id="chart-europe"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <svg class="bi text-success" width="32" height="32"
                                                        fill="blue" style="width:10px">
                                                        <use
                                                            xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
                                                    </svg>
                                                    <h5 class="mb-0 ms-3">America</h5>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="mb-0">375</h5>
                                            </div>
                                            <div class="col-12">
                                                <div id="chart-america"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="d-flex align-items-center">
                                                    <svg class="bi text-success" width="32" height="32"
                                                        fill="blue" style="width:10px">
                                                        <use
                                                            xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
                                                    </svg>
                                                    <h5 class="mb-0 ms-3">India</h5>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <h5 class="mb-0 text-end">625</h5>
                                            </div>
                                            <div class="col-12">
                                                <div id="chart-india"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <svg class="bi text-danger" width="32" height="32"
                                                        fill="blue" style="width:10px">
                                                        <use
                                                            xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
                                                    </svg>
                                                    <h5 class="mb-0 ms-3">Indonesia</h5>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="mb-0">1025</h5>
                                            </div>
                                            <div class="col-12">
                                                <div id="chart-indonesia"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Product Type</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-product-type"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </section>
    </div>
@endsection
@section('css')
    <style>
        .timeline {
            border-left: 3px solid #727cf5;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
            background: rgba(114, 124, 245, 0.09);
            margin: 0 auto;
            letter-spacing: 0.2px;
            position: relative;
            line-height: 1.4em;
            font-size: 1.03em;
            padding: 50px;
            list-style: none;
            text-align: left;
            max-width: 40%;
        }

        @media (max-width: 767px) {
            .timeline {
                max-width: 98%;
                padding: 25px;
            }
        }

        .timeline h1 {
            font-weight: 300;
            font-size: 1.4em;
        }

        .timeline h2,
        .timeline h3 {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .timeline .event {
            border-bottom: 1px dashed #e8ebf1;
            padding-bottom: 25px;
            margin-bottom: 25px;
            position: relative;
        }

        @media (max-width: 767px) {
            .timeline .event {
                padding-top: 30px;
            }
        }

        .timeline .event:last-of-type {
            padding-bottom: 0;
            margin-bottom: 0;
            border: none;
        }

        .timeline .event:before,
        .timeline .event:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .event:before {
            left: -207px;
            content: attr(data-date);
            text-align: right;
            font-weight: 100;
            font-size: 0.9em;
            min-width: 120px;
        }

        @media (max-width: 767px) {
            .timeline .event:before {
                left: 0px;
                text-align: left;
            }
        }

        .timeline .event:after {
            -webkit-box-shadow: 0 0 0 3px #727cf5;
            box-shadow: 0 0 0 3px #727cf5;
            left: -55.8px;
            background: #fff;
            border-radius: 50%;
            height: 9px;
            width: 9px;
            content: "";
            top: 5px;
        }

        @media (max-width: 767px) {
            .timeline .event:after {
                left: -31.8px;
            }
        }

        .rtl .timeline {
            border-left: 0;
            text-align: right;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
            border-right: 3px solid #727cf5;
        }

        .rtl .timeline .event::before {
            left: 0;
            right: -170px;
        }

        .rtl .timeline .event::after {
            left: 0;
            right: -55.8px;
        }
    </style>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/orders-data')
                .then(response => response.json())
                .then(data => {
                    // Map data to get readable month names
                    const monthNames = [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                    ];

                    let months = data.map(item => {
                        let [year, month] = item.month.split("-");
                        return `${monthNames[parseInt(month) - 1]} ${year}`;
                    });
                    let totals = data.map(item => item.total);

                    var options = {
                        series: [{
                            name: 'Orders',
                            data: totals
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                dataLabels: {
                                    position: 'top', // top, center, bottom
                                },
                            }
                        },

                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                return val;
                            },
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ["#7ABA78"]
                            }
                        },
                        xaxis: {
                            categories: months,
                            position: 'bottom',
                            labels: {
                                offsetY: -18,
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            crosshairs: {
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        colorFrom: '#D8E3F0',
                                        colorTo: '#BED1E6',
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 0.5,
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                            }
                        },
                        yaxis: {
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false,
                            },
                            labels: {
                                show: true,
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        },
                        title: {
                            text: 'Monthly Orders in the Past Year',
                            floating: true,
                            offsetY: 330,
                            align: 'center',
                            style: {
                                color: '#7ABA78'
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart-orders"), options);
                    chart.render();
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/product-type-data')
                .then(response => response.json())
                .then(data => {
                    let types = data.map(item => item.type);
                    let totals = data.map(item => item.total);

                    var options = {
                        series: totals,
                        chart: {
                            type: "donut",
                            width: "100%",
                            height: "350px",
                        },
                        labels: types,
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: "30%",
                                },
                            },
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200,

                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]

                    };

                    var chart = new ApexCharts(document.querySelector("#chart-product-type"), options);
                    chart.render();
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateSelect = document.getElementById('date');
            const contentDiv = document.getElementById('content');

            function fetchReservations(date) {
                fetch(`/api/reservations?date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        let content = '<ul class="timeline">';
                        if (data.length === 0) {
                            content += '<p>No reservation for the selected date</p>';
                        } else {
                            data.forEach(reservation => {
                                content += `
                                    <li class="event" data-date="${reservation.time.substring(0, 5)}">
                                        <h5 class="!tw-text-lg !tw-font-semibold">${reservation.name}</h5>
                                        <p><small>${reservation.phone}</small></p>
                                        <p><small>${reservation.people} people</small></p>
                                    </li>
                                `;
                            });
                        }
                        content += '</ul>';
                        contentDiv.innerHTML = content;
                    });
            }

            dateSelect.addEventListener('change', function() {
                fetchReservations(this.value);
            });

            // Fetch default reservations for today on page load
            fetchReservations('today');
        });
    </script>
@endsection
