<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Login</title>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-login-form.min.css') }}" />
</head>

<body>
    <section class="vh-100" style="background-color: #9A616D;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form id="loginForm">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Login</span>
                                        </div>
                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>
                                        <div class="form-floating mb-4">
                                            <input type="email" id="email" class="form-control form-control-lg" required placeholder="Email address" />
                                            <label for="email">Email address</label>
                                        </div>
                                        <div class="form-floating mb-4">
                                            <input type="password" id="password" class="form-control form-control-lg" required placeholder="Password" />
                                            <label for="password">Password</label>
                                        </div>

                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" id="rememberMe" />
                                            <label class="form-check-label" for="rememberMe"> Remember me </label>
                                        </div>
                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                        </div>
                                        <a class="small text-muted" href="#">Forgot password?</a>
                                        <p class="error-message text-danger d-none">Invalid login credentials.</p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault();

            console.log("Login form submitted!"); // Debugging

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const rememberMe = document.getElementById("rememberMe").checked;
            const errorMessage = document.querySelector(".error-message");

            console.log("Email:", email);
            console.log("Password:", password);

            fetch("/api/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" // Pastikan token ini valid
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                })
                .then(response => {
                    console.log("Response status:", response.status);
                    return response.json();
                })
                .then(data => {
                    console.log("Response data:", data);

                    if (data.message === "Login berhasil") { // Sesuaikan dengan respons API
                        const accessToken = data.access_token;
                        console.log("Login successful! Token:", accessToken);

                        if (rememberMe) {
                            localStorage.setItem('access_token', accessToken);
                        } else {
                            sessionStorage.setItem('access_token', accessToken);
                        }

                        console.log("Redirecting to /dashboard...");
                        setTimeout(() => {
                            window.location.href = "/dashboard"; // Redirect setelah login sukses
                        }, 500); // Delay untuk memastikan token tersimpan
                    } else {
                        console.warn("Login failed:", data);
                        errorMessage.classList.remove("d-none");
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    errorMessage.classList.remove("d-none");
                });
        });
    </script>

</body>

</html>