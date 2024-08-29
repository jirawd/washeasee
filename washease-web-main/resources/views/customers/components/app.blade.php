<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="utf-8"/>
    <title>{{ $title ?? 'Dashboard' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/img/dark-mode-washease.png">

    <!-- Datatables css -->
    <link href="customer_assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="customer_assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="customer_assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="customer_assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="customer_assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="customer_assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- default styles -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- with v4.1.0 Krajee SVG theme is used as default (and must be loaded as below) - include any of the other theme CSS files as mentioned below (and change the theme property of the plugin) -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />

    <!-- with v4.1.0 Krajee SVG theme is used as default (and must be loaded as below) - include any of the other theme JS files as mentioned below (and change the theme property of the plugin) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.js"></script>

    <!-- Theme Config Js -->
    <script src="customer_assets/js/config.js"></script>

    <!-- App css -->
    <link href="customer_assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>

    <!-- Icons css -->
    <link href="customer_assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<!-- Begin page -->
<div class="wrapper">

    @include('customers.components.header')


    @include('customers.components.sidebar')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                @yield('content')

            </div> <!-- container -->

        </div> <!-- content -->

        @include('customers.components.footer')

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->


<!-- Vendor js -->
<script src="customer_assets/js/vendor.min.js"></script>
<script src="customer_assets/vendor/lucide/umd/lucide.min.js"></script>

<!-- Datatables js -->
<script src="customer_assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="customer_assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="customer_assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="customer_assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="customer_assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
<script src="customer_assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="customer_assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="customer_assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="customer_assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="customer_assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="customer_assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="customer_assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="customer_assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

<!-- App js -->
<script src="customer_assets/js/app.min.js"></script>
<!-- Bootstrap Wizard Form js -->
<script src="customer_assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

<!-- Wizard Form Demo js -->
<script src="customer_assets/js/pages/form-wizard.init.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/star-rating.min.js" type="text/javascript"></script>

@stack('scripts')
</body>
</html>
