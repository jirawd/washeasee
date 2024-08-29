@php use Illuminate\Support\Number; @endphp
@extends('customers.components.app')
@section('content')

    <div class="row">
        <div class="col-xl-3">
            <div class="card overflow-hidden border-top-0">
                <div class="progress progress-sm rounded-0 bg-light" role="progressbar" aria-valuenow="88" aria-valuemin="0"
                     aria-valuemax="100">
                    <div class="progress-bar bg-warning" style="width: 100%"></div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <p class="text-muted fw-semibold fs-16 mb-1">Pending Orders</p>
                        </div>
                        <div class="avatar-sm mb-4">
                            <div class="avatar-title bg-warning-subtle text-warning fs-24 rounded">
                                <i class="bi bi-receipt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-end">
                        <h3 class="mb-0 d-flex"> {{ Number::format($customer_transactions_pending) }} </h3>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>


        <div class="col-xl-3">
            <div class="card overflow-hidden border-top-0">
                <div class="progress progress-sm rounded-0 bg-light" role="progressbar" aria-valuenow="88" aria-valuemin="0"
                     aria-valuemax="100">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <p class="text-muted fw-semibold fs-16 mb-1">Processing Orders</p>
                        </div>
                        <div class="avatar-sm mb-4">
                            <div class="avatar-title bg-primary-subtle text-primary fs-24 rounded">
                                <i class="bi bi-receipt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-end">
                        <h3 class="mb-0 d-flex">{{ Number::format($customer_transactions_processing) }} </h3>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>


        <div class="col-xl-3">
            <div class="card overflow-hidden border-top-0">
                <div class="progress progress-sm rounded-0 bg-light" role="progressbar" aria-valuenow="88" aria-valuemin="0"
                     aria-valuemax="100">
                    <div class="progress-bar bg-purple" style="width: 100%"></div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <p class="text-muted fw-semibold fs-16 mb-1">Ready for Pickup Orders</p>
                        </div>
                        <div class="avatar-sm mb-4">
                            <div class="avatar-title bg-purple-subtle text-purple fs-24 rounded">
                                <i class="bi bi-receipt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-end">
                        <h3 class="mb-0 d-flex">{{ Number::format($customer_transactions_ready_for_pickup) }} </h3>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>


        <div class="col-xl-3">
            <div class="card overflow-hidden border-top-0">
                <div class="progress progress-sm rounded-0 bg-light" role="progressbar" aria-valuenow="88" aria-valuemin="0"
                     aria-valuemax="100">
                    <div class="progress-bar bg-success" style="width: 100%"></div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <p class="text-muted fw-semibold fs-16 mb-1">Completed Orders</p>
                        </div>
                        <div class="avatar-sm mb-4">
                            <div class="avatar-title bg-success-subtle text-success fs-24 rounded">
                                <i class="bi bi-receipt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-end">
                        <h3 class="mb-0 d-flex">{{ Number::format($customer_transactions_completed) }}</h3>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>

    </div>



@endsection
