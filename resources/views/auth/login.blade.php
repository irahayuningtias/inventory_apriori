<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Floating Label -->
    <style>
        /* Floating Labels CSS */
        .form-group.floating>label {
            bottom: -1px;
            left: 18px;
            position: absolute;
            background-color: white;
            padding: 0px 5px 0px 5px;
            font-size: 1em;
            transition: 0.1s;
            pointer-events: none;
            transform-origin: bottom left;
        }

        .form-control.floating:focus~label{
            transform: translate(1px,-85%) scale(0.80);
            opacity: .8;
            color: #005ebf;
        }

        .form-control.floating:valid~label{
            transform-origin: bottom left;
            transform: translate(1px,-85%) scale(0.80);
            opacity: .8;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5">
                <div class="company-logo text-center">
                    <img src="{{ asset('assets/image/logo-hari-hari.png') }}" style="height: 100pt;" >
                </div>
                <h5 class="mb-4 mt-3 font-weight-bold text-center"> INVENTORY MANAGEMENT SYSTEM </h5>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group floating col-md-12 mb-4">
                        <input id="email" type="email" class="form-control floating @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <label for="email">Email</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    
                    <div class="form-group floating col-md-12 mb-4">
                        <input id="password" type="password" class="form-control floating @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <label for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="row mb-1 d-flex justify-content-center text-center">
                        <button type="submit" class="btn btn-primary" style="width:87%">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>

            </div>
            </div>
        </div>
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/avendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
   <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Floating Label -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>

</html>
