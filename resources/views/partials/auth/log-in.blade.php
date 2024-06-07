<main class="flex-grow-1">
    <!-- Container START -->
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100 py-5">
            <!-- Main content START -->
            <div class="col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5">
                <!-- Sign in START -->
                <div class="card card-body text-center p-4 p-sm-5">
                    <!-- Title -->
                    <h1 class="mb-2">Sign in</h1>
                    <p class="mb-0">Don't have an account?<a href="{{route('register')}}"> Click here to sign up</a></p>
                    <!-- Form START -->
                    <form class="mt-sm-4" action="{{ route('login') }}" method="post">
                        @csrf
                        <!-- Email -->
                        <div class="mb-3 input-group-lg">
                            <input type="email" class="form-control" placeholder="Enter email" name="email">
                        </div>
                        <!-- New password -->
                        <div class="mb-3 position-relative">
                            <!-- Password -->
                            <div class="input-group input-group-lg">
                                <input class="form-control fakepassword" type="password" id="psw-input" placeholder="Enter new password" name="password">
                                <span class="input-group-text p-0">
                                  <i class="fakepasswordicon fa-solid fa-eye-slash cursor-pointer p-2 w-40px"></i>
                                </span>
                            </div>
                        </div>
                        <!-- Remember me -->
                        <div class="mb-3 d-sm-flex justify-content-between">
                            <div>
                                <input type="checkbox" class="form-check-input" id="rememberCheck">
                                <label class="form-check-label" for="rememberCheck">Remember me?</label>
                            </div>
                            <a href="forgot-password.html">Forgot password?</a>
                        </div>
                        <!-- Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg btn-primary">Login</button>
                        </div>
                    </form>
                    <!-- Form END -->
                </div>
                <!-- Sign in START -->
            </div>
        </div> <!-- Row END -->
    </div>
    <!-- Container END -->

</main>
