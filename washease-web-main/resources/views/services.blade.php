@extends('components.layouts.app')
@section('content')

    <!-- Services -->
    <section class="service-area pt-100 pb-70">
        <div class="container">
            <div class="section-title">
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

@endsection
@pushonce('scripts')
    <script>
        console.log('Welcome page');
    </script>
@endpushonce
