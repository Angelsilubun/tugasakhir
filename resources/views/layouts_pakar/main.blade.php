<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard | @yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    {{ asset('assets/img/hero-img.png') }}
    <!-- Favicons -->
    <link href="{{ asset('assets/admin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/admin/img/apple-taouch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="{{ url('https://fonts.gstatic.com') }}" rel="preconnect">
    <link
        href="{{ url('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i') }}"
        rel="stylesheet">

    <style>
        @media (max-width: 767px) {

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                margin-top: 1rem;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: flex-start;
                /* Mengubah justify-content menjadi flex-start */
                gap: 1rem;
            }

            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input {
                width: 100%;
                max-width: 200px;
                display: inline-block;
            }

            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                text-align: center;
            }

            .dataTables_wrapper .dataTables_info {
                margin-top: 0.5rem;
            }

            .dataTables_wrapper .dataTables_paginate {
                margin-top: 0.5rem;
            }
        }
    </style>

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}

    <link href="{{ asset('assets/DataTables/datatables.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/checkbox-master/dist/pretty-checkbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/notyf/notyf.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tagify/dist/tagify.css') }}">

</head>

<body>

    @stack('style')

    {{-- @include('layouts_admin.header') --}}

    @include('layouts_pakar.header')

    @include('layouts_admin.sidebar')

    <div>
        @yield('container')
    </div>


    @stack('script')


    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/admin/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/notyf/notyf.min.js') }}" type="application/javascript"></script>
    <script src="{{ asset('assets/tagify/dist/tagify.min.js') }}"></script>
    <script src="{{ asset('assets/ckeditor5/ckeditor.js') }}"></script>
    {{-- <script src="{{ asset('assets/chartJS_4-3-0/package/dist/chart.umd.js') }}"></script> --}}

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js') }}"></script>
    {{-- <script src="{{ url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="{{ url('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script> --}}
    <script src="{{ url('https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js') }}"></script>

    <script src="{{ url('https://cdn.jsdelivr.net/npm/multiple-select@1.5.2/multiple-select.min.js') }}"></script>
    <link href="{{ url('https://cdn.jsdelivr.net/npm/multiple-select@1.5.2/multiple-select.min.css') }}"
        rel="stylesheet">
    <script>
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif (session()->has('error'))
            toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('js')
</body>

</html>
