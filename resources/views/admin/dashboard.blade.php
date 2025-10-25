@extends('admin.layouts.app')

@section('title', 'Dashboard | Car 4 Sales')


@section('style')
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Total Stock <span>| Today</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalstock }} </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title"> Total Booked Car <span>| {{$totalbooking}}</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p>Today</p>
                                        <h6>{{ $todaybookedcar }}</h6>
                                    </div>
                                    <div class="ps-3">
                                        <p>{{$currentMonthName}}</p>
                                        <h6>{{ $currentmonthbooking }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->
                     <!-- Delivary Card -->
                     <div class="col-xxl-4 col-md-4">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title"> Total Delivered Car <span>| {{ $totaldelivary }}</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p>Today</p>
                                        <h6>{{ $todaydelivary }}</h6>
                                    </div>
                                    <div class="ps-3">
                                        <p>{{$currentMonthName}}</p>
                                        <h6>{{ $currentmonthdelivary }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Delivary Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-md-4">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Total <span>| Contacts</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p>Total Contact</p>
                                        <h6>{{ $contacts }}</h6>
                                    </div>
                                    <div class="ps-3">
                                        <p>Today Contact</p>
                                        <h6>{{ $todaycontacts }}</h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->
                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-md-4">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Cloud Call Count</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cloud-check-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p>Old Data</p>
                                        <h6>{{ $cloud_contacts }}</h6>
                                    </div>
                                    <div class="ps-3">
                                        <p>New Total Data</p>
                                        <h6 id="qkonnectTotalData">Loading...</h6>
                                    </div>
                                    <div class="ps-3">
                                        <p>Today</p>
                                        <h6 id="qkonnectTodayData">Loading...</h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->
                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-md-4">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Total <span>| Visitor</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p>Total Visitor</p>
                                        <h6>{{ $totalvisitor }}</h6>
                                    </div>
                                    <div class="ps-3">
                                        <p>Today Visitor</p>
                                        <h6>{{ $todayvisitor }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- End Customers Card -->
                    <div class="col-xxl-4 col-md-4">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">SMS <span>| Balance</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p>SMS Balance</p>
                                        <h6>{{ $balance }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- End Customers Card -->
                    <div class="col-xxl-4 col-md-4">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Finance File <span>| Status</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p>Ready for Deliver</p>
                                        <h6>{{ $readyfordelivary }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- End Customers Card --> 
                     <!-- Revenue Card -->
                     <div class="col-xxl-3 col-md-3">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Folloup Pending</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people-fill" style = "color:red;"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $Pendingtilltoday }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                </div>

    </section>
@endsection

@section('script')

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        function fetchDashboardData() {
            $.ajax({
                url: "{{ route('dashboard_data') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#qkonnectTotalData').text(response.total_qkonnect_data);
                    $('#qkonnectTodayData').text(response.today_qkonnect_contacts);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching dashboard data:', error);
                }
            });
        }
        // Initial fetch
        fetchDashboardData();
        // Set interval to fetch data every 1 minutes (300000 milliseconds)
        setInterval(fetchDashboardData, 60000);
    });

</script>

@endsection
