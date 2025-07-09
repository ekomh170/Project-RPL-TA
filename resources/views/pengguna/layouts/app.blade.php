<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'HandyGo - Platform Jasa Terpercaya' }}</title>
    <meta name="description"
        content="{{ $description ?? 'Platform jasa harian terpercaya untuk berbagai kebutuhan Anda' }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        @media (min-width: 576px) {
            .container-fluid {
                padding-left: 30px;
                padding-right: 30px;
            }
        }

        @media (min-width: 992px) {
            .container-fluid {
                padding-left: 50px;
                padding-right: 50px;
            }
        }

        /* Responsive Images */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Button Styles */
        .btn-primary {
            background-color: #3ab8ff;
            border-color: #3ab8ff;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
        }

        /* Responsive Typography */
        h1 {
            font-size: 2rem;
        }

        h2 {
            font-size: 1.75rem;
        }

        h3 {
            font-size: 1.5rem;
        }

        @media (min-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            h2 {
                font-size: 2.25rem;
            }

            h3 {
                font-size: 1.75rem;
            }
        }

        @media (min-width: 992px) {
            h1 {
                font-size: 3rem;
            }

            h2 {
                font-size: 2.5rem;
            }

            h3 {
                font-size: 2rem;
            }
        }
    </style>

    <!-- Page-specific styles -->
    @stack('styles')
</head>

<body>
    @include('pengguna.partials.header', ['title' => $title ?? 'HandyGo'])

    <main>
        @yield('content')
    </main>

    @include('pengguna.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Page-specific scripts -->
    @stack('scripts')
</body>

</html>
