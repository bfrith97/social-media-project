<main>

    <!-- Container START -->
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100 py-5">
            <!-- Main content START -->
            <div class="col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5">
                <!-- Sign up START -->
                <div class="card card-body rounded-3 p-4 p-sm-5">
                    <div class="text-center">
                        <!-- Title -->
                        <h1 class="mb-2">Sign up</h1>
                        <span class="d-block">Already have an account? <a href="{{route('login')}}">Sign in here</a></span>
                    </div>
                    <!-- Form START -->
                    <form class="mt-4" method="post">
                        @csrf
                        <!-- Email -->
                        <div class="mb-3 input-group-lg">
                            <input type="email" class="form-control" placeholder="Enter email" name="email">
                            <div class="d-flex justify-content-between">
                                <input type="text" class="form-control mt-2 me-2" placeholder="Enter full name" name="name">
                            </div>
                        </div>
                        <!-- New password -->
                        <div class="mb-3 position-relative">
                            <!-- Pswmeter -->
                            <div id="pswmeter" class="mt-2"></div>
                            <div class="d-flex mt-1">
                                <div id="pswmeter-message" class="rounded"></div>
                                <!-- Password message notification -->
                                <div class="ms-auto">
                                    <i class="bi bi-info-circle ps-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Include at least one uppercase, one lowercase, one special character, one number and 8 characters long." data-bs-original-title="" title=""></i>
                                </div>
                            </div>
                            <!-- Input group -->
                            <div class="input-group input-group-lg">
                                <input class="form-control fakepassword" type="password" name="password" id="psw-input" placeholder="Enter new password">
                                <span class="input-group-text p-0">
                                  <i class="fakepasswordicon fa-solid fa-eye-slash cursor-pointer p-2 w-40px"></i>
                                </span>
                            </div>

                        </div>
                        <!-- Confirm password -->
                        <div class="mb-3 input-group-lg">
                            <input class="form-control" type="password" placeholder="Confirm password" name="password_confirmation">
                        </div>
                        <!-- Keep me signed in -->
                        <div class="mb-3 text-start">
                            <input type="checkbox" class="form-check-input" id="keepsingnedCheck">
                            <label class="form-check-label" for="keepsingnedCheck"> Keep me signed in</label>
                        </div>
                        <!-- Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg btn-primary">Sign me up</button>
                        </div>
                    </form>
                    <!-- Form END -->
                </div>
                <!-- Sign up END -->
            </div>
        </div> <!-- Row END -->
    </div>
    <!-- Container END -->

</main>

<script src="assets/vendor/pswmeter/pswmeter.min.js"></script>
