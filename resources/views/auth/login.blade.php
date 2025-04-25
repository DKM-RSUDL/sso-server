<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSUD Langsa Single Sign On</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            height: 100vh;
            margin: 0;
            font-family: sans-serif
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .logo img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .logo h4 {
            margin: 0;
            font-weight: bold;
            font-size: 20px;
        }

        .welcome-text {
            margin-bottom: 1.5rem;
            font-weight: 600;
            width: fit-content;
        }

        .form-control {
            border-radius: 5px;
        }

        .footer {
            margin-top: 1.5rem;
            background-color: #e7f3ff;
            padding: 0.5rem;
            text-align: center;
            border-radius: 5px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="row justify-content-center align-items-center h-100 w-100">
        <div class="col-lg-6 col-md-7">
            <div class="login-container">
                <div class="logo">
                    <img src="{{ asset('assets/img/logo-rsudlangsa.png') }}" alt="RSUD Langsa Logo">
                    <h4>RSUD Langsa Single Sign On</h4>
                </div>
                <p class="welcome-text form-control">Hey, how have you been? <span style="color: #007bff;">👋</span></p>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="number" class="form-control" name="kd_karyawan" placeholder="Employee Code"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS (Optional, for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
