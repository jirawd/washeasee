@extends('components.layouts.app')
@section('content')

    @php
        use App\Models\LaundryShopRatings;
        use App\Models\Services;
        $reviews = LaundryShopRatings::limit(5)->orderBy('created_at', 'DESC')->get();
        $services = Services::limit(6)->get();
    @endphp

    <!-- Choose -->
    <div class="choose-area pt-100 pb-70">
        <div class="choose-shape">
            <img src="assets/img/home-one/choose1.png" alt="Shape">
            <img src="assets/img/home-one/banner-shape3.png" alt="Shape">
            <img src="assets/img/home-one/choose2.png" alt="Shape">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="choose-content">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-lg-6">
                                <div class="col-lg-12 p-0">
                                    <div class="choose-item">
                                        <i class='bx bx-network-chart'></i>
                                        <h3>Self  Service</h3>
                                        <p>Enjoy Hassle-Free Self-Service!</p>
                                    </div>
                                </div>
                                <div class="col-lg-12 p-0">
                                    <div class="choose-item">
                                        <i class='bx bx-paper-plane'></i>
                                        <h3>We Pickup</h3>
                                        <p>WashEase delivery driver pick up your order.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-6">
                                <div class="choose-item">
                                    <i class='bx bx-wrench'></i>
                                    <h3>We Deliver</h3>
                                    <p>Your clothes are dropped off clean and ready to wear.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-contact">
                        <div class="section-title">
                            <span class="sub-title">How WashEase Works</span>
                            <h2>Enjoy Hassle-Free Self-Service!</h2>
                        </div>
{{--                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur harum qui, beatae aliquid, esse modi asperiores, sit ea pariatur ipsa quaerat repellendus voluptatibus commodi doloremque architecto. Dignissimos doloremque quod modi.</p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Choose -->

    <!-- Services -->
    <section class="service-area pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">Our Services</span>
                <h2>We Are Committed To Give Our Best Services</h2>
            </div>
            <div class="row">

                @foreach($services as $service)
                    <div class="col-sm-6 col-lg-4">
                        <div class="service-item">
                            <div class="service-top">
                                <img src="https://png.pngtree.com/png-clipart/20230916/original/pngtree-an-orange-washing-machine-vector-png-image_12233120.png" alt="Service">
                                <img src="https://png.pngtree.com/png-clipart/20230916/original/pngtree-an-orange-washing-machine-vector-png-image_12233120.png" alt="Service">
                            </div>
                            <h3>
                                <a href="service-details.html">{{ $service->service_name }}</a>
                            </h3>
                            <p>
                                {{ $service->description }}
                            </p>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </section>
    <!-- End Services -->

    <section class="service section bg-gray-50">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Prefer using your phone?</h2>
                        <p><a href="">Wash Ease App</a><br>
                            Our mobile app is built for convenience letting you manage your laundry anytime, anywhere. </p>

                        <a href="/washease.apk" class="btn btn-dark btn-lg mt-5"> DOWNLOAD OUR APK! </a>
                    </div>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 align-self-end">
                    <!-- Feature Image -->
                    <div class="service-thumb a aos-init aos-animate w-100 d-flex justify-content-end" data-aos="fade-right">
                        <img class="img-responsive w-100" src="{{ asset('assets/img/phone.png') }}" alt="iphone-ipad">
                    </div>
                </div>
                <div class="col-lg-5 mr-auto align-self-center">
                    <div class="service-box">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-xs-12">
                                <!-- Service 01 -->
                                <div class="service-item">
                                    <!-- Icon -->
                                    <i class="ti-bookmark"></i>
                                    <!-- Heading -->
                                    <h3>Find Nearby Laundry Shops</h3>
                                    <!-- Description -->
                                    <p>You can find laundry shops nearby and pick the one that works best for you.  </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <!-- Service 01 -->
                                <div class="service-item">
                                    <!-- Icon -->
                                    <i class="ti-pulse"></i>
                                    <!-- Heading -->
                                    <h3>Schedule a Laundry</h3>
                                    <!-- Description -->
                                    <p>You can schedule your laundry service right from your phone.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <!-- Service 01 -->
                                <div class="service-item">
                                    <!-- Icon -->
                                    <i class="ti-bar-chart"></i>
                                    <!-- Heading -->
                                    <h3>Real-time Laundry Tracking</h3>
                                    <!-- Description -->
                                    <p>You can track the rider as they come to you, and send them messages if you need to. </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <!-- Service 01 -->
                                <div class="service-item">
                                    <!-- Icon -->
                                    <i class="ti-panel"></i>
                                    <!-- Heading -->
                                    <h3>Customer Feedback and Review</h3>
                                    <!-- Description -->
                                    <p>You can leave feedback and a review for the shop to share your experience.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Review -->
    <section class="review-area ptb-100">
        <div class="review-shape">
            <img src="assets/img/home-one/banner-shape6.png" alt="Shape">
        </div>
        <div class="container">
            <div class="section-title">
                <span class="sub-title">Clients Review</span>
                <h2>What clients Say About Us</h2>
            </div>
            <div class="review-slider owl-theme owl-carousel">
                @foreach($reviews as $review)
                    <div class="review-item">
                        <h3>{{ $review->customer->name }}</h3>
                        <span>CUSTOMER</span>
                        <ul>
                            @for($i = 0; $i <= $review->rating_count; $i++)
                            <li>
                                <i class='bx bxs-star @if($i) checked @endif'></i>
                            </li>
                            @endfor
                        </ul>
                        <p>
                            {{ $review->rating_comment }}
                        </p>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- End Review -->

@endsection
@pushonce('scripts')
        <script>
            console.log('Welcome page');
        </script>
@endpushonce
