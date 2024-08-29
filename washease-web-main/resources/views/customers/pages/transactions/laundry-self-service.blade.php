@php use Illuminate\Support\Number; @endphp
@extends('customers.components.app')
@section('content')

    <a href="javascript:history.back()" class="btn btn-dark mb-3"> Go Back </a>

    <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show d-none" id="alert_notification"
         role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>ATTENTION - </strong> There's no available Washing Machine right now! Please Come back later. Thank You!
    </div>

    <div id="display_all_services">

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"> Basic Services</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="basic_services_container">

                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"> Ironing Services</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="ironing_services_container">

                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"> Dry Cleaning Services</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="dry_cleaning_services_container">

                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->

            <div class="card">
                <div class="card-header">
                    <h4 class=".card-title mb-0"> Selling Items</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="selling_items_container">

                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->

            <div class="card">
                <div class="card-header">
                    <h4 class=".card-title mb-0"> Washing Machines </h4>
                </div>
                <div class="card-body">
                    <div class="row" id="washing_machines_container">

                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->

        </div> <!-- end col -->

        <div class="col-4">
            <div class="card">
                <div class="card-body">

                    <!-- Invoice Logo-->
                    <div class="clearfix">
                        <div class="float-start mb-3">
                            <h2 class="m-0 d-print-none">Invoice</h2>
                        </div>
                        <div class="float-end">

                        </div>
                    </div>

                    <!-- Invoice Detail-->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="float-end mt-3">
                                <p><b>Hello, {{ Auth::user()->name }}</b></p>
                                <p class="text-muted fs-13">Please find below a cost-breakdown for the recent order
                                    you've selected.
                                    Please make payment at your earliest convenience, and do not hesitate to contact us
                                    with any questions.</p>
                            </div>

                        </div><!-- end col -->
                        <div class="col-sm-4 offset-sm-2">
                            <div class="mt-3 float-sm-end">
                                <p class="fs-13"><strong>Order Date: </strong> &nbsp;&nbsp;&nbsp; {{ date('F d, Y') }}
                                </p>
                                <p class="fs-13"><strong>Order Tracker #: </strong> <span
                                        class="float-end">{{ Str::random(8) }}</span></p>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row mt-4">
                        <div class="col-6">
                            <h6 class="fs-14">Billing Address</h6>
                            <address>
                                {{ Auth::user()->address }} <br>
                                <abbr title="Phone">Contact #:</abbr> {{ Auth::user()->phone_number }}
                            </address>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-centered table-hover table-borderless mb-0 mt-3">
                                    <thead class="border-top border-bottom bg-light-subtle border-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="invoice_body">

                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="clearfix pt-3">
                                <img src="{{ asset('customer_assets/images/GCASH-WASHEASE.png') }}" class="d-none" id="gcash-payment" />
                                <h6 class="text-muted fs-14">Payment Method:</h6>
                                <select class="form-select" id="payment_method">
                                    <option value="CASH" selected>CASH</option>
                                    <option value="GCASH">GCASH</option>
                                </select>
                            </div>
                            <div class="float-end mt-5">
                                <p><b>VAT (12.5 / 12.5%):</b> <span class="float-end" id="vat_total">₱0.00</span></p>
                                <h3 id="total_bill">₱0.00 PHP</h3>
                            </div>
                        </div> <!-- end col -->
                        <div class="col-sm-6 mt-7">

                            <div class="clearfix"></div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row-->

                    <div class="d-print-none mt-4">
                        <div class="text-end">
                            <button id="send_order" href="javascript: void(0);" class="btn btn-soft-danger">Submit</button>
                        </div>
                    </div>
                    <!-- end buttons -->

                </div> <!-- end card-body-->
            </div>
        </div> <!-- end col -->
    </div>
    </div>
@endsection

@once
    @push('scripts')
        <script src="https://unpkg.com/bs5-toast/dist/bs5-toast.js"></script>
        <script>
            const get_basic_services_by_laundry_shops_api = "{{ route('api.get.basic.services.by.laundry.shops') }}";
            const get_all_laundry_shops_washing_machines_api = "{{ route('api.get.all.laundry.shops.washing.machines') }}";
            // Retrieve the value from localStorage
            var token = localStorage.getItem('bearerToken');

            $(document).ready(function () {
                const laundry_shop_id = localStorage.getItem('laundry_shop_id');
                get_basic_services_by_laundry_shops(laundry_shop_id);
                checkIfMachinesIsAvailable(laundry_shop_id);
            });

            function checkIfMachinesIsAvailable(laundry_shop_id) {
                $.post(get_basic_services_by_laundry_shops_api, {
                    laundry_shop_id: laundry_shop_id
                }, function (response) {
                    const countAllAvailableWashingMachine = response.count_all_available_washing_machine;

                    if (countAllAvailableWashingMachine > 0) {
                        $("#display_all_services").removeClass('d-none');
                        $("#alert_notification").addClass('d-none');
                    } else {
                        $("#display_all_services").addClass('d-none');
                        $("#alert_notification").removeClass('d-none');

                    }

                });
            }

            $("#payment_method").on("change", function(e){
                if($("#payment_method").val() === 'GCASH') {
                    $("#gcash-payment").removeClass('d-none');
                } else {
                    $("#gcash-payment").addClass('d-none');
                }
            });

            function get_basic_services_by_laundry_shops(laundry_shop_id) {
                $.post(get_basic_services_by_laundry_shops_api, {
                    laundry_shop_id: laundry_shop_id
                }, function (response) {
                    const basicServices = response.data;
                    const ironingServices = response.ironing;
                    const dryCleaningServices = response.dry_cleaning;
                    const sellingItems = response.selling_items;
                    const washingMachines = response.washing_machine;
                    const basic_services_container = $('#basic_services_container');
                    const ironing_services_container = $('#ironing_services_container');
                    const dry_cleaning_services_container = $('#dry_cleaning_services_container');
                    const selling_items_container = $('#selling_items_container');
                    const washing_machines_container = $('#washing_machines_container');


                    // Clear previous content if needed
                    basic_services_container.empty();
                    ironing_services_container.empty();
                    dry_cleaning_services_container.empty();
                    selling_items_container.empty();
                    washing_machines_container.empty();

                    basicServices.forEach(function (service) {
                        const basic_services_card = `
                        <div class="col-md-3">
                            <div class="card border-secondary border">
                                <div class="card-body">
                                    <h5 class="card-title">${service.service_name}</h5>
                                    <p class="card-text">${service.description}</p>
                                    <p class="card-text">Price: ₱ ${service.price}</p>
                                    <button data-service_id="${service.id}" class="btn btn-purple btn-sm w-100">Select Service</button>
                                </div>
                            </div>
                        </div>`;

                        // Append each card to the container
                        basic_services_container.append(basic_services_card);
                    });

                    ironingServices.forEach(function (service_ironing) {
                        const ironing_services_card = `
                        <div class="col-md-3">
                            <div class="card border-secondary border">
                                <div class="card-body">
                                    <h5 class="card-title">${service_ironing.service_name}</h5>
                                    <p class="card-text">${service_ironing.description}</p>
                                    <p class="card-text">Price: ₱ ${service_ironing.price}</p>
                                    <button data-service_id="${service_ironing.id}" class="btn btn-purple btn-sm w-100">Select Service</button>
                                </div>
                            </div>
                        </div>`;

                        // Append each card to the container
                        ironing_services_container.append(ironing_services_card);
                    });

                    dryCleaningServices.forEach(function (service_dry_cleaning) {
                        const dry_cleaning_services_card = `
                        <div class="col-md-3">
                            <div class="card border-secondary border">
                                <div class="card-body">
                                    <h5 class="card-title">${service_dry_cleaning.service_name}</h5>
                                    <p class="card-text">${service_dry_cleaning.description}</p>
                                    <p class="card-text">Price: ₱ ${service_dry_cleaning.price}</p>
                                    <button data-service_id="${service_dry_cleaning.id}" class="btn btn-purple btn-sm w-100">Select Service</button>
                                </div>
                            </div>
                        </div>`;

                        // Append each card to the container
                        dry_cleaning_services_container.append(dry_cleaning_services_card);
                    });

                    sellingItems.forEach(function (selling_items) {
                        const selling_items_card = `
                        <div class="col-md-3">
                            <div class="card border-secondary border">
                                <div class="card-body">
                                    <img src="storage/${selling_items.item_image}" class="w-50 mb-3" alt="${selling_items.item_name}"/>
                                    <h5 class="card-title">${selling_items.item_name}</h5>
                                    <p class="card-text">${selling_items.item_category}</p>
                                    <p class="card-text">Price: ₱ ${selling_items.item_price}</p>
                                    <button data-service_id="${selling_items.id}" class="btn btn-purple btn-sm w-100">Get Item</button>
                                </div>
                            </div>
                        </div>`;

                        // Append each card to the container
                        selling_items_container.append(selling_items_card);
                    });

                    // Loop through each basic service and generate HTML
                    washingMachines.forEach(function (machine) {
                        // Determine if the machine button should be disabled
                        const isDisabled = (machine.status === 'Not Available' || machine.status === 'Reserve') ? 'disabled' : '';
                        const badgeColor = (machine.status === 'Not Available' || machine.status === 'Reserve') ? 'bg-danger' : 'bg-success';

                        const washing_machine_card = `
                        <div class="col-md-3">
                            <div class="card border-secondary border">
                                <div class="card-body">
                                    <h5 class="card-title">${machine.machine_name}</h5>
                                    <p class="card-text">${machine.machine_type}</p>
                                    <p class="card-text">Note: ${machine.notes}</p>
                                    <span class="badge ${badgeColor}">${machine.status}</span>
                                    <button data-washing_machine_id="${machine.id}" class="btn btn-purple btn-sm w-100 mt-2" ${isDisabled}>Select Machine</button>
                                </div>
                            </div>
                        </div>`;
                        // Append each card to the container
                        washing_machines_container.append(washing_machine_card);

                        // Attach event listener to the button
                        const button = washing_machines_container.find(`[data-washing_machine_id="${machine.id}"]`);
                        button.on('click', function () {
                            // Get the washing machine ID
                            const washingMachineId = $(this).data('washing_machine_id');
                            new bs5.Toast({
                                body: 'Machine Selected Successfully!',
                                className: 'border-0 bg-success text-white',
                                btnCloseWhite: true,
                            }).show()
                            // Save the washing machine ID to localStorage
                            localStorage.setItem('selectedWashingMachineId', washingMachineId);
                        });
                    });



                    // Event listener for selecting a service
                    basic_services_container.on('click', '.btn.btn-purple', function () {
                        const serviceId = $(this).data('service_id');
                        const selectedService = basicServices.find(service => service.id === serviceId);

                        // Get quantity (you might want to prompt the user for this)
                        const quantity =
                            1; // For demonstration purpose, you can modify this according to your requirement

                        // Calculate total including VAT
                        const {
                            subtotal,
                            vat,
                            total
                        } = calculateTotal(selectedService.price, quantity);

                        // Append to invoice table
                        const newRow = $(`
                        <tr>
                            <td data-id="${serviceId}">${$('#invoice_body tr').length + 1}</td>
                            <td>${selectedService.service_name}</td>
                            <td>${quantity}</td>
                            <td class="text-end">${total.toFixed(2)}</td>
                            <td class="text-end"><button class="btn btn-danger btn-sm remove-item">Remove</button></td>
                        </tr>
                    `);

                        newRow.find('.remove-item').click(function () {
                            $(this).closest('tr').remove();
                            updateInvoiceTotals();
                        });

                        $('#invoice_body').append(newRow);

                        updateInvoiceTotals();
                    });

                    // Event listener for selecting an item
                    ironing_services_container.on('click', '.btn.btn-purple', function () {
                        const itemId = $(this).data('service_id');
                        const selectedItem = ironingServices.find(service_ironing => service_ironing.id === itemId);

                        // Get quantity (you might want to prompt the user for this)
                        const quantity = 1;

                        // Calculate total including VAT
                        const {
                            subtotal,
                            vat,
                            total
                        } = calculateTotal(selectedItem.price, quantity);

                        // Append to invoice table
                        const newRow = $(`
                            <tr>
                                <td data-id="${itemId}">${$('#invoice_body tr').length + 1}</td>
                                <td>${selectedItem.service_name}</td>
                                <td>${quantity}</td>
                                <td class="text-end">${total.toFixed(2)}</td>
                                <td class="text-end"><button class="btn btn-danger btn-sm remove-item">Remove</button></td>
                            </tr>
                        `);

                        newRow.find('.remove-item').click(function () {
                            $(this).closest('tr').remove();
                            updateInvoiceTotals();
                        });

                        $('#invoice_body').append(newRow);

                        updateInvoiceTotals();
                    });

                    // Event listener for selecting an item
                    dry_cleaning_services_container.on('click', '.btn.btn-purple', function () {
                        const itemId = $(this).data('service_id');
                        const selectedItem = dryCleaningServices.find(service_dry_cleaning => service_dry_cleaning.id === itemId);


                        // Get quantity (you might want to prompt the user for this)
                        const quantity =
                            1; // For demonstration purpose, you can modify this according to your requirement

                        // Calculate total including VAT
                        const {
                            subtotal,
                            vat,
                            total
                        } = calculateTotal(selectedItem.price, quantity);

                        // Append to invoice table
                        const newRow = $(`
                            <tr>
                                <td data-id="${itemId}">${$('#invoice_body tr').length + 1}</td>
                                <td>${selectedItem.service_name}</td>
                                <td>${quantity}</td>
                                <td class="text-end">${total.toFixed(2)}</td>
                                <td class="text-end"><button class="btn btn-danger btn-sm remove-item">Remove</button></td>
                            </tr>
                        `);

                        newRow.find('.remove-item').click(function () {
                            $(this).closest('tr').remove();
                            updateInvoiceTotals();
                        });

                        $('#invoice_body').append(newRow);

                        updateInvoiceTotals();
                    });

                    // Event listener for selecting an item
                    selling_items_container.on('click', '.btn.btn-purple', function () {
                        const itemId = $(this).data('service_id');
                        const selectedItem = sellingItems.find(item => item.id === itemId);

                        // Get quantity (you might want to prompt the user for this)
                        const quantity =
                            1; // For demonstration purpose, you can modify this according to your requirement

                        // Calculate total including VAT
                        const {
                            subtotal,
                            vat,
                            total
                        } = calculateTotal(selectedItem.item_price, quantity);

                        // Append to invoice table
                        const newRow = $(`
                            <tr>
                                <td data-id="${itemId}">${$('#invoice_body tr').length + 1}</td>
                                <td>${selectedItem.item_name}</td>
                                <td>${quantity}</td>
                                <td class="text-end">${total.toFixed(2)}</td>
                                <td class="text-end"><button class="btn btn-danger btn-sm remove-item">Remove</button></td>
                            </tr>
                        `);

                        newRow.find('.remove-item').click(function () {
                            $(this).closest('tr').remove();
                            updateInvoiceTotals();
                        });

                        $('#invoice_body').append(newRow);

                        updateInvoiceTotals();
                    });

                });
            }

            // Function to calculate total including VAT
            function calculateTotal(price, quantity) {
                const subtotal = price * quantity;
                const vat = subtotal * 0.12;
                const total = subtotal + vat;
                return {
                    subtotal,
                    vat,
                    total
                };
            }
            // Function to update VAT and total bill amounts
            function updateInvoiceTotals() {
                let subtotal = 0;

                // Calculate subtotal
                $('#invoice_body tr').each(function () {
                    const price = parseFloat($(this).find('td:eq(3)').text().replace('₱', ''));
                    subtotal += price;
                });

                // Calculate VAT
                const vat = subtotal * 0.125;

                // Get delivery fee
                let deliveryFee = 0;
                if ($('#customRadio2').is(':checked')) {
                    deliveryFee = 200;
                }


                // Update VAT display
                $('#vat_total').text(vat.toFixed(2));

                // Update total bill including VAT
                const totalBill = subtotal + vat + deliveryFee;
                $('#total_bill').text(`₱${totalBill.toFixed(2)}`);
            }

            // Listen for changes to the delivery option
            $('#customRadio1, #customRadio2').on('change', function () {
                updateInvoiceTotals();
            });

            // Event listener for removing an item
            $('#invoice_body').on('click', '.remove-item', function () {
                $(this).closest('tr').remove();
                updateInvoiceTotals();
            });

            $('#send_order').on('click', function() {
                // Gather data from the invoice table
                const invoiceData = [];
                $('#invoice_body tr').each(function() {
                    const serviceId = $(this).find('td:first').data('id');
                    const serviceName = $(this).find('td:eq(1)').text();
                    const servicePrice = parseFloat($(this).find('td:eq(3)').text().replace('$', ''));
                    const quantity = parseInt($(this).find('td:eq(2)').text());

                    // Check if the item is in the selling_items_container div using data-service_id
                    const isInSellingItemsContainer = $('#selling_items_container').find(`[data-service_id='${serviceId}']`).length > 0;

                    invoiceData.push({
                        service: serviceId,
                        service_name: serviceName,
                        service_price: servicePrice,
                        quantity: quantity,
                        inventory_item_id: serviceId,
                        inventory_item_name: serviceName,
                        inventory_item_quantity: quantity,
                        is_inventory_item: isInSellingItemsContainer,
                    });
                });


                // Get delivery fee
                let deliveryFee = 0;
                if ($('#customRadio2').is(':checked')) {
                    deliveryFee = 200;
                }

                // Calculate total bill
                const totalBill = parseFloat($('#total_bill').text().replace('₱', '').trim());

                // Get payment method
                const paymentMethod = $('#payment_method').val();

                // Prepare data to be sent via AJAX
                const postData = {
                    service_avail: invoiceData,
                    total_bill: totalBill,
                    customer_id: {{ Auth::user()->id }},
                    laundry_shop_id: localStorage.getItem('laundry_shop_id'),
                    customer_name: "{{ Auth::user()->name }}",
                    customer_address: "{{ Auth::user()->address }}",
                    customer_type: "{{ Auth::user()->role }}",
                    payment_method: paymentMethod,
                    delivery_fee: deliveryFee,
                    status: 'PENDING',
                    machine_id: localStorage.getItem('selectedWashingMachineId'),
                    service_type: localStorage.getItem('service_type')
                };

                // Send data via AJAX
                $.ajax({
                    url: '{{ route('api.laundry-shop.transactions.create', 'laundry-shop') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    data: JSON.stringify(postData),
                    success: function(response) {
                        new bs5.Toast({
                            body: response.message,
                        }).show();

                        window.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error submitting order:', error);
                    }
                });
            });
        </script>
    @endpush
@endonce
