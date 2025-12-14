@extends('admin.layouts.app')

@section('title', 'Dashboard | Car 4 Sales')

@section('style')
    <style>
        body {
            background: #f5f7fb
        }

        .modern-card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 12px 28px rgba(0, 0, 0, .06);
            transition: .3s
        }

        .modern-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .12)
        }

        .icon-box {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #fff
        }

        .icon-blue {
            background: linear-gradient(135deg, #007bff, #00c6ff)
        }

        .icon-green {
            background: linear-gradient(135deg, #22c55e, #16a34a)
        }

        .icon-purple {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9)
        }

        .icon-orange {
            background: linear-gradient(135deg, #f59e0b, #f97316)
        }

        .metric {
            font-size: 30px;
            font-weight: 700;
            color: #1e293b
        }

        .metric-label {
            font-size: 13px;
            color: #64748b;
            text-transform: uppercase
        }

        .chart-card {
            border-radius: 20px;
            box-shadow: 0 14px 35px rgba(0, 0, 0, .08)
        }

        @media(max-width:768px) {
            .metric {
                font-size: 24px
            }

            .icon-box {
                width: 48px;
                height: 48px;
                font-size: 22px
            }
        }
    </style>
@endsection

@section('content')

    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div>

    <section class="section dashboard">

        <!-- KPI ROW 1 -->
        <div class="row g-4">

            <!-- TOTAL STOCK -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card modern-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="metric-label">Total Stock</div>
                            <div class="metric live-counter" data-key="total-stock">{{ $totalstock }}</div>
                        </div>
                        <div class="icon-box icon-blue"><i class="bi bi-car-front-fill"></i></div>
                    </div>
                </div>
            </div>

            <!-- TOTAL BOOKED -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card modern-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="metric-label">Total Booked</div>
                                <div class="metric live-counter" data-key="total-booked">{{ $totalbooking }}</div>
                            </div>
                            <div class="icon-box icon-green"><i class="bi bi-check-circle-fill"></i></div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between text-center">
                            <div>
                                <small>Today</small>
                                <h6>{{ $todaybookedcar }}</h6>
                            </div>
                            <div>
                                <small>{{ $currentMonthName }}</small>
                                <h6>{{ $currentmonthbooking }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DELIVERED -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card modern-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="metric-label">Delivered</div>
                                <div class="metric live-counter" data-key="delivered-cars">{{ $totaldelivary }}</div>
                            </div>
                            <div class="icon-box icon-purple"><i class="bi bi-truck"></i></div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between text-center">
                            <div>
                                <small>Today</small>
                                <h6>{{ $todaydelivary }}</h6>
                            </div>
                            <div>
                                <small>{{ $currentMonthName }}</small>
                                <h6>{{ $currentmonthdelivary }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- KPI ROW 2 -->
        <div class="row g-4 mt-1">
            <!-- CLOUD CALL -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card modern-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="metric-label">Cloud Calls</div>
                                <div class="metric live-counter" data-key="cloud-calls">{{ $cloud_contacts }}</div>
                            </div>
                            <div class="icon-box icon-blue"><i class="bi bi-cloud-check-fill"></i></div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between text-center">
                            <div>
                                <small>Today</small>
                                <h6>{{ $today_qkonnect_contacts }}</h6>
                            </div>
                            <div>
                                <small>Qkonnect</small>
                                <h6>{{ $qkonnect_contacts }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTACTS -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card modern-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="metric-label">Total Contacts</div>
                                <div class="metric live-counter" data-key="total-contacts">{{ $contacts }}</div>
                            </div>
                            <div class="icon-box icon-orange"><i class="bi bi-people-fill"></i></div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small>Today</small>
                            <h6>{{ $todaycontacts }}</h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- CHART ROW -->
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card chart-card">
                    <div class="card-body">
                        <h5 class="fw-bold">📊 Delivery Report</h5>
                        <div style="height:320px">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function animateValue(el, start, end) {
            let s = null;

            function step(t) {
                if (!s) s = t;
                let p = Math.min((t - s) / 800, 1);
                el.innerText = Math.floor(p * (end - start) + start);
                if (p < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        function refreshKPIs() {
            $.get("{{ route('dashboard.live.kpis') }}", function(data) {
                $('.live-counter').each(function() {
                    let key = $(this).data('key');
                    if (data[key] !== undefined) {
                        let oldVal = parseInt($(this).text());
                        if (oldVal !== data[key]) {
                            animateValue(this, oldVal, data[key]);
                        }
                    }
                });
            });
        }
        refreshKPIs();
        setInterval(refreshKPIs, 60000);
    </script>

    <script>
        $(function() {

            let deliveryChart;

            function loadDeliveryChart() {

                $.ajax({
                    url: "{{ route('chart.data') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(res) {

                        // 🔴 SAFETY CHECK (VERY IMPORTANT)
                        if (!res.labels || !res.booking || !res.delivery) {
                            console.error('Invalid chart data:', res);
                            return;
                        }

                        const ctx = document.getElementById('barChart').getContext('2d');

                        if (deliveryChart) {
                            deliveryChart.destroy();
                        }

                        // BAR GRADIENT
                        const barGradient = ctx.createLinearGradient(0, 0, 0, 300);
                        barGradient.addColorStop(0, '#36a2eb');
                        barGradient.addColorStop(1, '#9bd0f5');

                        deliveryChart = new Chart(ctx, {
                            data: {
                                labels: res.labels,
                                datasets: [{
                                        type: 'bar',
                                        label: 'Delivered Cars',
                                        data: res.delivery,
                                        backgroundColor: barGradient,
                                        borderRadius: 12,
                                        borderSkipped: false
                                    },
                                    {
                                        type: 'line',
                                        label: 'Booked Cars',
                                        data: res.booking,
                                        borderColor: '#22c55e',
                                        backgroundColor: 'rgba(34,197,94,0.15)',
                                        tension: 0.4,
                                        fill: true,
                                        pointRadius: 5,
                                        pointHoverRadius: 7,
                                        pointBackgroundColor: '#22c55e'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                animation: {
                                    duration: 1200,
                                    easing: 'easeOutQuart'
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            usePointStyle: true,
                                            padding: 16
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: '#1e293b',
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        cornerRadius: 8
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: '#e5e7eb'
                                        },
                                        ticks: {
                                            precision: 0
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error('Chart AJAX error:', xhr.responseText);
                    }
                });
            }

            // Initial load
            loadDeliveryChart();

            // OPTIONAL auto refresh
            // setInterval(loadDeliveryChart, 60000);
        });
    </script>



@endsection
