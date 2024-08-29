<div id="laundry-services-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Select Services</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card border-secondary border">
                            <div class="card-body">
                                <h5 class="card-title">SELF SERVICE</h5>
                                <a href="{{ route('customer.self.service') }}" data-service_type="self_service" id="laundry_self_service_id" class="btn btn-soft-purple btn-sm w-100">SELECT</a>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-md-4">
                        <div class="card border-primary border">
                            <div class="card-body">
                                <h5 class="card-title text-primary">PICKUP & DELIVERY</h5>
                                <a href="{{ route('customer.pickup.delivery') }}" data-service_type="pickup_and_delivery" id="laundry_pickup_and_delivery_id" class="btn btn-soft-purple btn-sm w-100">SELECT</a>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-md-4">
                        <div class="card border-success border">
                            <div class="card-body">
                                <h5 class="card-title text-success">PICKUP ONLY</h5>
                                <a href="{{ route('customer.pickup.only') }}" data-service_type="pickup" id="laundry_pickup_only_id" class="btn btn-soft-purple btn-sm w-100">SELECT</a>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
