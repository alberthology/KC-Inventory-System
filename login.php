<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>Auth Section</title>
</head>

<body>

    <!-- blue circle background -->
    <div class="d-none d-md-block ball login bg-primary bg-gradient position-absolute rounded-circle"></div>

    <!-- Login Section -->
    <div class="container login__form active">
        <div class="row vh-100 w-100 align-self-center">
            <div class="col-12 col-lg-6 col-xl-6 px-5">
                <div class="row vh-100">
                    <div class="col align-self-center p-5 w-100">
                        <h3 class="fw-bolder">WELCOME BACK !</h3>
                        <p class="fw-lighter fs-6">Don't have an account, <span id="signUp" role="button" class="text-primary">Sign Up</span></p>
                        <!-- form login section -->
                        <form action="" class="mt-5">
                            <div class="mb-3">
                                <label for="username" class="form-label">Email</label>
                                <input type="email" class="form-control text-indent shadow-sm bg-grey-light border-0 rounded-pill fw-lighter fs-7 p-3" placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Password</label>
                                <div class="d-flex position-relative">
                                    <input type="password" class="form-control text-indent auth__password shadow-sm bg-grey-light border-0 rounded-pill fw-lighter fs-7 p-3">
                                    <span class="password__icon text-primary fs-4 fw-bold bi bi-eye-slash"></span>
                                </div>
                            </div>
                            <div class="col text-center">
                                <button type="submit" class="btn btn-outline-dark btn-lg rounded-pill mt-4 w-100">Login</button>
                            </div>
                        </form>
                        <p class="mt-5 text-center">Or Sign in with social platforms</p>
                        <div class="row text-center">
                            <div class="col mt-3">
                                <a href="" class="btn btn-outline-dark border-2 rounded-circle"><i class="bi bi-facebook fs-5"></i></a>
                            </div>
                            <div class="col mt-3">
                                <a href="" class="btn btn-outline-dark border-2 rounded-circle"><i class="bi bi-linkedin fs-5"></i></a>
                            </div>
                            <div class="col mt-3">
                                <a href="" class="btn btn-outline-dark border-2 rounded-circle"><i class="bi bi-twitter fs-5"></i></a>
                            </div>
                            <div class="col my-3">
                                <a href="" class="btn btn-outline-dark border-2 rounded-circle"><i class="bi bi-google fs-5"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none d-lg-block col-lg-6 col-xl-6 p-5">
                <div class="row vh-100 p-5">
                    <div class="col align-self-center p-5 text-center">
                        <img src="assets/images/login.png" class="bounce" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
</body>

</html>