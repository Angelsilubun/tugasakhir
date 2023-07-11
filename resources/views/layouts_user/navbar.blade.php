<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sistem Pakar | @yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../../../assets/img/favicon.png" rel="icon">
    <link href="../../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../../../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JS -->
    {{-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> --}}
    <!-- Template Main CSS File -->
    <link href="../../../assets/css/style.css" rel="stylesheet">
    <link href="{{ asset('assets/DataTables/datatables.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/checkbox-master/dist/pretty-checkbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/notyf/notyf.min.css') }}">
</head>

<body>

    @stack('style')

    @include('layouts_user.header')

    <div>
        @yield('container')
    </div>

    @include('layouts_user.footer')

    @stack('js')

    <!-- Vendor JS Files -->
    <script src="../../../assets/vendor/aos/aos.js"></script>
    <script src="../../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../../../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../../../assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/notyf/notyf.min.js') }}" type="application/javascript"></script>
    <!-- Template Main JS File -->
    <script src="../../../assets/js/main.js"></script>

    <script>
        $(document).ready(function() {
            $('#diagnosaTable').DataTable();
        });
    </script>

</body>

</html>
