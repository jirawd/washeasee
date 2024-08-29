@extends('components.layouts.app')
@section('content')

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="text-left">
                <h2>Create Account</h2>
            </div>
            <p class="text-small">
                Please fill in the form to create an account, All fields are required.
            </p>
            <div class="col-sm-12 col-md-12 col-lg-12" id="contactForm">

                <label for="account_type" class="form-label fs-6">Account Type <span
                        class="text-danger">*</span></label>
                <select class="wide mb-3" id="account_type">
                    <option data-display="Select Account Type">Select Account Type</option>
                    <option value="Customer" selected>Customer</option>
                    <option value="laundry_shop">Laundry Shop</option>
                </select>

                <div class="form-group mt-3">
                    <label for="first_name" class="form-label fs-6">First Name <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="first_name"/>
                </div>

                <div class="form-group mt-3">
                    <label for="last_name" class="form-label fs-6">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="last_name"/>
                </div>

                <div class="form-group mt-3">
                    <label for="password" class="form-label fs-6">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" autocomplete="new-password"/>
                </div>

                <div class="form-group mt-3">
                    <label for="home_address" class="form-label fs-6">Home Address <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="home_address"/>
                </div>


                <div class="form-group mt-3">
                    <label for="laundry_shop_name" id="laundry_shop_name_label" class="form-label fs-6 d-none">Laundry
                        Shop Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control d-none" id="laundry_shop_name"/>
                </div>

                <div class="form-group mt-3">
                    <label for="laundry_shop_address" id="laundry_shop_address_label" class="form-label fs-6 d-none">Laundry
                        Shop Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control d-none" id="laundry_shop_address"/>
                </div>

                <div class="form-group mt-3">
                    <label for="laundry_shop_permit" id="laundry_shop_permit_label" class="form-label fs-6 d-none">Laundry
                        Shop Permit <span class="text-danger">*</span></label>
                    <input type="file" class="form-control d-none" name="laundry_shop_permit" id="laundry_shop_permit"/>
                </div>

                <input type="hidden" name="laundry_shop_latitude" id="laundry_shop_latitude" />
                <input type="hidden" name="laundry_shop_longitude" id="laundry_shop_longitude" />
                <input type="hidden" name="user_latitude" id="user_latitude" />
                <input type="hidden" name="user_longitude" id="user_longitude" />

                <div class="form-group mt-3">
                    <label for="email_address" class="form-label fs-6">Email Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="email_address" autocomplete="new-email-addresss"/>
                </div>

                <div class="form-group mt-3">
                    <label for="phone_number" class="form-label fs-6">Phone Number <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone_number"/>
                </div>

                <div class="col-md-12 col-lg-12 mt-3">
                    <button type="button" class="btn btn-md btn-outline-primary" id="create_new_account">
                        Submit
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection
@pushonce('scripts')
    <script src="https://unpkg.com/bs5-toast/dist/bs5-toast.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
            integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

        const account_type = $("#account_type");
        const first_name = $("#first_name");
        const last_name = $("#last_name");
        const password = $("#password");
        const home_address = $("#home_address");
        const email = $("#email_address");
        const phone_number = $("#phone_number");
        const laundry_shop_name = $("#laundry_shop_name");
        const laundry_shop_address = $("#laundry_shop_address");
        const laundry_shop_latitude = $("#laundry_shop_latitude");
        const laundry_shop_longitude = $("#laundry_shop_longitude");
        const user_latitude = $("#user_latitude");
        const user_longitude = $("#user_longitude");


        first_name.keyup(function () {
            $(this).val($(this).val().replace(/[^a-zA-Z\s]/g, ''));
        });

        last_name.keyup(function () {
            $(this).val($(this).val().replace(/[^a-zA-Z\s]/g, ''));
        });

        email.keyup(function () {
            $(this).val($(this).val().replace(/[^a-zA-Z0-9@.]/g, ''));
        });


        $(document).ready(function (e) {
            phone_number.mask('0000-000-0000');

        });

        account_type.niceSelect({width: "100%",});

        account_type.change(function (e) {
            e.preventDefault();
            if ($(this).val() === 'Customer') {
                $("#laundry_shop_name").addClass('d-none');
                $("#laundry_shop_name_label").addClass('d-none');
                $("#laundry_shop_address_label").addClass('d-none');
                $("#laundry_shop_permit_label").addClass('d-none');
                $("#laundry_shop_address").addClass('d-none');
                $("#laundry_shop_permit").addClass('d-none');

            } else {
                $("#laundry_shop_name").removeClass('d-none');
                $("#laundry_shop_name_label").removeClass('d-none');
                $("#laundry_shop_permit_label").removeClass('d-none');
                $("#laundry_shop_address_label").removeClass('d-none');
                $("#laundry_shop_address").removeClass('d-none');
                $("#laundry_shop_permit").removeClass('d-none');
            }
        });

        // Event handler for the change event of the home_address input field
        laundry_shop_address.change(function (e){
            // Get the value of the input field
            var address = $(this).val();

            // Call getAddressConfidence function with appropriate URL and address
            getAddressConfidence('{{ route('api.get-address') }}', address)
                .then(validationResult  => {
                    // If validation is confirmed or partially confirmed, set latitude and longitude values
                    if (validationResult.validation === 'CONFIRMED' || validationResult.validation === 'PARTIALLY_CONFIRMED') {
                        // Make another request to fetch full data
                        $.post('{{ route('api.get-address') }}', {
                            address: address,
                        }).then(data => {
                            const result = JSON.parse(data);
                            const firstResult = result.results[0];
                            console.log("RESULT", data);
                            // Set latitude and longitude values to input fields
                            laundry_shop_latitude.val(firstResult.lat);
                            laundry_shop_longitude.val(firstResult.lon);
                        }).catch(error => console.error('Error:', error));
                    }
                })
                .catch(error => console.error('Error:', error)); // Handle errors if any
        });

        home_address.change(function (e){
            var address = $(this).val();
            getAddressConfidence('{{ route('api.get-address') }}', address)
                .then(validationResult  => {
                    if (validationResult.validation === 'CONFIRMED' || validationResult.validation === 'PARTIALLY_CONFIRMED') {
                        $.post('{{ route('api.get-address') }}', {
                            address: address,
                        }).then(data => {
                            const result = JSON.parse(data);
                            const firstResult = result.results[0];
                            console.log("RESULT", data);
                            // Set latitude and longitude values to input fields
                            user_latitude.val(firstResult.lat);
                            user_longitude.val(firstResult.lon);
                        }).catch(error => console.error('Error:', error));
                    }
                })
                .catch(error => console.error('Error:', error)); // Handle errors if any
        });




        $("#create_new_account").click(function (e) {
            e.preventDefault();

            let formData = new FormData();
            const laundry_shop_permit = $("#laundry_shop_permit");
            // Access the file input element using jQuery and get the files property using prop()
            const files = laundry_shop_permit.prop('files');

            if (files && files.length > 0) {
                formData.append("laundry_shop_permit", files[0]);
            }

            const fields = {
                role: account_type.val(),
                first_name: first_name.val(),
                last_name: last_name.val(),
                password: password.val(),
                email: email.val(),
                address: home_address.val(),
                user_lat: home_address.val(),
                user_long: home_address.val(),
                phone_number: phone_number.val(),
                laundry_shop_name: laundry_shop_name.val(),
                laundry_shop_address: laundry_shop_address.val(),
                laundry_shop_latitude: laundry_shop_latitude.val(),
                laundry_shop_longitude: laundry_shop_longitude.val(),
                _token: "{{ csrf_token() }}"
            }

            $.each(fields, function (key, value) {
                // Check if the value is empty for each field if the account type is customer do not check for laundry shop name and address
                if (value === '' && key !== 'laundry_shop_name' && key !== 'laundry_shop_address' && key !== 'laundry_shop_latitude' && key !== 'laundry_shop_longitude') {
                    new bs5.Toast({
                        body: 'The ' + key.replace(/_/g, ' ') + ' field is required',
                        className: 'border-0 bg-danger text-white',
                        btnCloseWhite: true,
                    }).show();
                    return false;
                } else {
                    if (fields.role === 'laundry_shop') {
                        if (fields.laundry_shop_name === '' || fields.laundry_shop_address === '') {
                            new bs5.Toast({
                                body: 'The laundry shop name and address field is required',
                                className: 'border-0 bg-danger text-white',
                                btnCloseWhite: true,
                            }).show();
                            return false;
                        }
                    }
                }

                // check if email is valid
                if (key === 'email') { // Changed key to 'email'
                    if (!validateEmail(value)) {
                        new bs5.Toast({
                            body: 'The email address is invalid',
                            className: 'border-0 bg-danger text-white',
                            btnCloseWhite: true,
                        }).show();
                        return false;
                    }
                }
            });

            // Append fields to formData
            for (const key in fields) {
                formData.append(key, fields[key]);
            }

            // If all fields are valid
            $.ajax({
                url: "{{ route('api.auth.register') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data, status) {
                    console.log(status);
                    if (status === 'success') {
                        new bs5.Toast({
                            body: data.message,
                            className: 'border-0 bg-success text-white',
                            btnCloseWhite: true,
                        }).show();

                        // clear all fields
                        $.each(fields, function (key, value) {
                            $(`#${key}`).val('');
                        });

                    } else {
                        new bs5.Toast({
                            body: data.message,
                            className: 'border-0 bg-danger text-white',
                            btnCloseWhite: true,
                        }).show();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr, status, error);
                }
            });
        });


        function validateEmail(email) {
            const re = /\S+@\S+\.\S+/;
            return re.test(email);
        }

        function getAddressConfidence(url, address) {

            const ACCEPT_LEVEL = 0.95;
            const DECLINE_LEVEL = 0.2;
            const validationResult = {};
            const  laundry_shop_latitude = $("#laundry_shop_latitude");
            const  laundry_shop_longitude = $("#laundry_shop_longitude");

            // Send a POST request to the API
            return $.post(url, {
                address: address,
            }).then(response => {
                const result = JSON.parse(response); // Parse the JSON response
                const results = result.results;

                if (results.length === 0) {
                    validationResult.validation = 'NOT_CONFIRMED';
                    return validationResult;
                }

                const addressData = results[0];

                if (addressData.rank && addressData.rank.confidence) {
                    if (addressData.rank.confidence >= ACCEPT_LEVEL) {
                        validationResult.validation = 'CONFIRMED';

                    } else if (addressData.rank.confidence < DECLINE_LEVEL) {
                        validationResult.validation = 'NOT_CONFIRMED';
                    } else {
                        validationResult.validation = 'PARTIALLY_CONFIRMED';
                    }
                } else {
                    console.error('Error: Confidence data is missing in the response');
                    validationResult.validation = 'ERROR';
                }

                return validationResult;
            }).catch(error => {
                console.error('Error:', error);
                return { validation: 'ERROR' };
            });
        }





    </script>
@endpushonce
