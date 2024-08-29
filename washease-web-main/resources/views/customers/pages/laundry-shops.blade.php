@extends('customers.components.app')
@section('content')

    <div class="row" id="shops_list">
        @foreach($laundry_shops as $shops)
            <div class="col-sm-6 col-lg-3">
                <div class="card {{ ($shops->is_shop_closed === 1) ? '' : 'border border-danger' }}">
                    <img src="https://t4.ftcdn.net/jpg/03/69/82/25/360_F_369822526_1RM10KzOIeiDChifl9aESFDDTJ4xwwFo.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><span class="text-muted">Shop Name:</span> {{ $shops->laundry_shop_name }}</h5>
                        <p class="card-text">
                            <i class="mdi mdi-map-marker"></i> {{ $shops->laundry_shop_address }}
                        </p>
                        <p class="card-text fs-5">
                            Ratings:
                            @php
                                $totalStars = 5; // Total number of stars to display
                                $ratingCount = $shops->shops_rating->isEmpty() ? 0 : $shops->shops_rating->first()->rating_count;
                            @endphp

                            @for($i = 1; $i <= $totalStars; $i++)
                                <i class="mdi mdi-star fs-4 {{ $i <= $ratingCount ? 'text-warning' : '' }}"></i>
                            @endfor
                        </p>
                        @if($shops->is_shop_closed === 1)
                            <span class="badge bg-success w-100 p-2"> Open </span>
                        @else
                            <span class="badge bg-danger w-100 p-2"> Closed </span>
                        @endif

                        <button class="btn btn-primary mt-2 rounded-pill {{ ($shops->is_shop_closed === 1) ? '' : 'd-none' }}" id="select_shop_id" data-shop_id="{{ $shops->id }}" data-bs-toggle="modal" data-bs-target="#laundry-services-modal">
                            Select this Shop
                        </button>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col-->
        @endforeach


    </div>
    <!-- end row -->

    @include('customers.modals.laundry-services')
@endsection
@once
    @push('scripts')
        <script>
            const services_url = "{{ route('api.get.all.services.category') }}";
            const shops_list = $("#shops_list");

            shops_list.on("click", "#select_shop_id", function(e){
                e.preventDefault();
                const laundry_shop_id = $(this).data('shop_id');
                const laundry_self_service_id = $("#laundry_self_service_id");
                const laundry_pickup_and_delivery_id = $("#laundry_pickup_and_delivery_id");
                const laundry_pickup_only_id = $("#laundry_pickup_only_id");


                laundry_self_service_id.attr({
                    'data-laundry_shop_id': laundry_shop_id,
                });

                laundry_self_service_id.click(function (e){
                    const service_type = $(this).data('service_type');
                    localStorage.setItem('laundry_shop_id', laundry_shop_id);
                    localStorage.setItem('service_type', service_type);
                });

                laundry_pickup_and_delivery_id.attr({
                    'data-laundry_shop_id': laundry_shop_id,
                });

                laundry_pickup_and_delivery_id.click(function (e){
                    const service_type = $(this).data('service_type');
                    localStorage.setItem('laundry_shop_id', laundry_shop_id);
                    localStorage.setItem('service_type', service_type);
                });

                laundry_pickup_only_id.attr({
                    'data-laundry_shop_id': laundry_shop_id,
                });

                laundry_pickup_only_id.click(function (e){
                    const service_type = $(this).data('service_type');
                    localStorage.setItem('laundry_shop_id', laundry_shop_id);
                    localStorage.setItem('service_type', service_type);
                });

            });



        </script>
    @endpush
@endonce
