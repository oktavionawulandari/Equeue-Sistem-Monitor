<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Antrian General Static">
    <meta name="author" content="Ade Rahman">

    <!-- Title -->
    <title>Aplikasi Antrian General Static</title>

    <!-- Favicon icon -->
    <link href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon" rel="shortcut icon">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/vendor/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="{{ asset('assets/vendor/css/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Font -->
    <link href="{{ asset('assets/vendor/css/swap.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link href="{{ asset('assets/vendor/css/datatables.min.css') }}" type="text/css" rel="stylesheet">

    <!-- Custom Style -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <div class="container pt-4">
            <div class="d-flex flex-column flex-md-row px-4 py-3 mb-4 bg-white rounded-2 shadow-sm">
                <!-- Judul halaman -->
                <div class="d-flex align-items-center me-md-auto">
                    <i class="bi-gear-fill text-success me-3 fs-3"></i>
                    <h1 class="h5 pt-2">Setting Aplikasi Antrian</h1>
                </div>
                <!-- Breadcrumbs -->
                <div class="ms-5 ms-md-0 pt-md-3 pb-md-0">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bi-house-fill text-success"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Setting</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="container pt-5">
                    <div class="row justify-content-lg-center">
                        <div class="col-lg-5 mb-4">
                            <div class="px-4 py-3 mb-4 bg-white rounded-2 shadow-sm">
                                <div class="d-flex justify-content-center align-items-center me-md-auto">
                                    <i class="bi-lock-fill text-success me-3 fs-5"></i>
                                    <h1 class="h5 pt-2">Login Admin</h1>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-body d-grid p-5">
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                                </div>
                                                <!-- Button Pengambilan Nomor Antrian -->
                                                <button type="submit" class="btn btn-success btn-block">
                                                    <i class="bi-unlock-fill me-2 fs-4"></i> Login
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-4">
        <div class="container">
            <hr class="my-4">
            <!-- Copyright -->
            <div class="copyright text-center mb-2 mb-md-0">&copy; {{ date('Y') }} - <a href="https://paperlesshospital.id" target="_blank" class="text-brand text-decoration-none">paperlesshospital.id</a>. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- jQuery Core -->
    <script src="{{ asset('assets/vendor/js/jquery-3.6.0.min.js') }}" type="text/javascript"></script>
    <!-- Popper and Bootstrap JS -->
    <script src="{{ asset('assets/vendor/js/popper.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/vendor/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <!-- DataTables -->
    <script src="{{ asset('assets/vendor/js/datatables.min.js') }}" type="text/javascript"></script>
</body>

</html>
