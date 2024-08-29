@php use Illuminate\Support\Number; @endphp
@extends('customers.components.app')
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class=".card-title">My Profile</h4>
        </div>
        <div class="card-body">

            <img src="{{ Auth::user()->avatar }}" class="rounded-5"/>
            <p class="mt-2"><b>Name: </b> {{ Auth::user()->name }}</p>
            <p><b>Address: </b> {{ Auth::user()->address }}</p>
            <p><b>Email: </b> {{ Auth::user()->email  }}</p>
            <p><b>Contact Number: </b> {{ Auth::user()->phone_number }}</p>

        </div> <!-- end card body-->
    </div> <!-- end card -->

    @include('customers.modals.customer-review')
@endsection
@once
    @push('scripts')
        <script src="https://unpkg.com/bs5-toast/dist/bs5-toast.js"></script>
        <script>

        </script>
    @endpush
@endonce
