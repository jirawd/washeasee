@php use Illuminate\Support\Number; @endphp
@extends('customers.components.app')
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class=".card-title">Transactions</h4>
        </div>
        <div class="card-body">
            <table id="my-laundry-table" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>Services Avail</th>
                    <th>Payment Status</th>
                    <th>Kilo</th>
                    <th>Status</th>
                    <th>Total Bill</th>
                    <th>Completion Date</th>
                    <th>Days</th>
                    <th> Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user_laundry as $laundry)
                    <tr>
                        <td>
                            @php
                                $services = is_array($laundry->service_avail) ? $laundry->service_avail : json_decode($laundry->service_avail, true);
                            @endphp
                            <ul>
                                @if(is_array($services))
                                    @foreach($services as $service)
                                        <li>{{ $service['service_name'] . ' - ' . Number::currency(intval($service['service_price']), 'PHP') }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                        <td>
                            @if($laundry->payment_status === 'PAID')
                                <span class="badge bg-success">{{ $laundry->payment_status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $laundry->payment_status }}</span>
                            @endif
                        </td>
                        <td> {{ $laundry->kilo }} kg</td>
                        <td>
                            @if($laundry->status === 'PENDING')
                                <span class="badge bg-warning">{{ $laundry->status }}</span>
                            @elseif($laundry->status === 'PROCESSING')
                                <span class="badge bg-primary">{{ $laundry->status }}</span>
                            @elseif($laundry->status === 'READY FOR PICKUP')
                                <span class="badge bg-info">{{ $laundry->status }}</span>
                            @elseif($laundry->status === 'COMPLETED')
                                <span class="badge bg-success">{{ $laundry->status }}</span>
                            @endif
                        </td>
                        <td> {{ Number::currency($laundry->total_bill, 'PHP') }}</td>
                        <td> {{ date('F d, Y', strtotime($laundry->delivery_date)) }}</td>
                        <td>
                            @php
                                $deliveryDate = strtotime($laundry->delivery_date);
                                $today = strtotime(date('Y-m-d'));

                                $differenceInDays = ($deliveryDate - $today) / (60 * 60 * 24);
                            @endphp

                            @if ($differenceInDays == 1)
                                Today
                            @endif
                        </td>
                        <td>
                            @if($laundry->status === 'COMPLETED')
                                <button class="btn btn-info"
                                        id="review_btn"
                                        data-bs-target="#review-services-modal"
                                        data-laundry_shop_id="{{ $laundry->laundry_shop_id }}"
                                        data-service_id="{{ $laundry->id }}"
                                        data-bs-toggle="modal"> Give Review
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div> <!-- end card body-->
    </div> <!-- end card -->

    @include('customers.modals.customer-review')
@endsection
@once
    @push('scripts')
        <script src="https://unpkg.com/bs5-toast/dist/bs5-toast.js"></script>
        <script>
            $("#my-laundry-table").DataTable({
                keys: !0,
                language: {
                    paginate: {
                        previous: "<i class='ri-arrow-left-s-line'>",
                        next: "<i class='ri-arrow-right-s-line'>",
                    },
                },
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass(
                        "pagination-rounded"
                    );
                },
            });

            $("#my-laundry-table").on('click', '#review_btn', function (e) {
                e.preventDefault();
                const laundry_shop_id = $(this).data('laundry_shop_id');
                localStorage.setItem('laundry_shop_id_review', laundry_shop_id);
            });

            $("#rating_star").rating({
                'size': 'md',
                'step': 1
            });

            $('#rating_star').on('rating:change', function (event, value, caption) {
                localStorage.setItem('star_count', value);
            });


            $("#submit_review").click(function (e) {
                e.preventDefault();

                const rating_comment = $("textarea#rating_comment").val();
                const star_count = localStorage.getItem('star_count');
                const laundry_shop_id = localStorage.getItem('laundry_shop_id_review');
                const customer_id = {{ Auth::id() }};

                $.ajax({
                    url: "{{ route('api.laundry-shop.laundry-shop-ratings.create', 'laundry-shop') }}",
                    type: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('bearerToken')
                    },
                    data: {
                        customer_id: customer_id,
                        laundry_shop_id: laundry_shop_id,
                        rating_count: star_count,
                        rating_comment: rating_comment
                    },
                    success: function (data) {
                        new bs5.Toast({
                            body: "Review has been Submitted",
                        }).show();

                        $("#review-services-modal").modal('hide');

                        window.location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });



            });
        </script>
    @endpush
@endonce
