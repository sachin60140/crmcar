@extends('employee.layouts.app')

@section('title', 'Dashboard | Car 4 Sales')

@section('style')
<style>
    /* Make the card clickable and add a hover effect */
    .dashboard-card {
        transition: transform 0.3s ease;
        text-decoration: none; /* Remove underline from links */
        color: inherit; /* Keep text color normal */
        display: block;
    }
    .dashboard-card:hover {
        transform: translateY(-5px); /* Lift up slightly on hover */
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    /* Icon background adjustments */
    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }
</style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Employee Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('employee/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            
            <div class="col-xxl-3 col-xl-3 col-md-6">
                <a href="#" class="dashboard-card"> <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Leads <span>| Today</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle bg-light text-primary">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $pending_lead_data }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xxl-3 col-xl-3 col-md-6">
                <a href="#" class="dashboard-card">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Calling Followup</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle bg-light text-success">
                                    <i class="bi bi-telephone-outbound-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $calling_followup_data }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xxl-3 col-xl-3 col-md-6">
                <a href="#" class="dashboard-card">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Visitor Followup</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle bg-light text-info">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $visit_followup_data }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xxl-3 col-xl-3 col-md-6">
                <a href="#" class="dashboard-card">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Overdue Followups</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle bg-light text-warning">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $Pendingtilltoday }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xxl-3 col-xl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Wrong Number</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle bg-light text-danger">
                                <i class="bi bi-telephone-x-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $wrong_number_data }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Not Answered</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle bg-light text-danger">
                                <i class="bi bi-telephone-minus-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $not_answer_number_data }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Not Interested</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle bg-light text-secondary">
                                <i class="bi bi-emoji-frown-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $not_intrested_data }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Reject After Visit</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle bg-light text-danger">
                                <i class="bi bi-person-x-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $after_visit_reject_data }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection