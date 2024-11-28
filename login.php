<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Căn chỉnh toàn bộ khung ở giữa màn hình */
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Chiều cao màn hình */
            background-color: #f8f9fa; /* Màu nền nhẹ */
        }

        .form-container {
            background-color: #ffffff; /* Màu nền trắng */
            padding: 2rem; /* Khoảng cách nội dung */
            border-radius: 10px; /* Bo góc */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng */
            max-width: 400px; /* Chiều rộng tối đa */
            width: 100%; /* Chiều rộng chiếm 100% trong khung */
        }

        .nav-pills .nav-link {
            font-weight: bold;
        }

        .text-center a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <!-- Trung tâm màn hình -->
    <div class="center-container">
        <div class="form-container">
            <!-- Pills navs -->
            <ul class="nav nav-pills nav-justified mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login"
                        type="button" role="tab" aria-controls="pills-login" aria-selected="true">
                        Login
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register"
                        type="button" role="tab" aria-controls="pills-register" aria-selected="false">
                        Register
                    </button>
                </li>
            </ul>
            <!-- Pills navs -->

            <!-- Pills content -->
            <div class="tab-content">
                <!-- Login Tab -->
                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
                    <form>
                        <div class="text-center mb-3">
                            <p>Sign in with:</p>
                            <button type="button" class="btn btn-link btn-floating mx-1">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button type="button" class="btn btn-link btn-floating mx-1">
                                <i class="fab fa-google"></i>
                            </button>
                            <button type="button" class="btn btn-link btn-floating mx-1">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button type="button" class="btn btn-link btn-floating mx-1">
                                <i class="fab fa-github"></i>
                            </button>
                        </div>

                        <p class="text-center">or:</p>

                        <!-- Email input -->
                        <div class="mb-4">
                            <label for="loginName" class="form-label">Email or username</label>
                            <input type="email" id="loginName" class="form-control" />
                        </div>

                        <!-- Password input -->
                        <div class="mb-4">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" id="loginPassword" class="form-control" />
                        </div>

                        <!-- Checkbox and Forgot password -->
                        <div class="row mb-4">
                            <div class="col-md-6 d-flex">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="loginCheck" checked />
                                    <label class="form-check-label" for="loginCheck"> Remember me </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="#!">Forgot password?</a>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-4 w-100">Sign in</button>

                        <!-- Register link -->
                        <div class="text-center">
                            <p>Not a member? <a href="#!">Register</a></p>
                        </div>
                    </form>
                </div>

                <!-- Register Tab -->
                <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
                    <form>
                        <div class="text-center mb-3">
                            <p>Sign up with:</p>
                            <button type="button" class="btn btn-link btn-floating mx-1">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button type="button" class="btn btn-link btn-floating mx-1">
                                <i class="fab fa-google"></i>
                            </button>
                            <button type="button" class="btn btn-link btn-floating mx-1">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button type="button" class="btn btn-link btn-floating mx-1">
                                <i class="fab fa-github"></i>
                            </button>
                        </div>

                        <p class="text-center">or:</p>

                        <!-- Name input -->
                        <div class="mb-4">
                            <label for="registerName" class="form-label">Name</label>
                            <input type="text" id="registerName" class="form-control" />
                        </div>

                        <!-- Username input -->
                        <div class="mb-4">
                            <label for="registerUsername" class="form-label">Username</label>
                            <input type="text" id="registerUsername" class="form-control" />
                        </div>

                        <!-- Email input -->
                        <div class="mb-4">
                            <label for="registerEmail" class="form-label">Email</label>
                            <input type="email" id="registerEmail" class="form-control" />
                        </div>

                        <!-- Password input -->
                        <div class="mb-4">
                            <label for="registerPassword" class="form-label">Password</label>
                            <input type="password" id="registerPassword" class="form-control" />
                        </div>

                        <!-- Repeat Password input -->
                        <div class="mb-4">
                            <label for="registerRepeatPassword" class="form-label">Repeat password</label>
                            <input type="password" id="registerRepeatPassword" class="form-control" />
                        </div>

                        <!-- Checkbox -->
                        <div class="form-check d-flex justify-content-center mb-4">
                            <input class="form-check-input me-2" type="checkbox" id="registerCheck" checked />
                            <label class="form-check-label" for="registerCheck"> I have read and agree to the terms </label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-3 w-100">Register</button>
                    </form>
                </div>
            </div>
            <!-- Pills content -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
