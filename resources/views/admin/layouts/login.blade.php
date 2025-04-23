<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>

    <!-- Poppins Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Box Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Styles / Scripts -->
    @vite('resources/css/app.css')

    <!-- Global Javascript -->
    <script src="{{ asset('js/admin/app.js') }}" defer></script>
</head>

<body>
    <div class="flex items-center justify-center bg-[#CCCCCC] h-screen p-12">

        @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'title' => 'Data Valid!', 'message' => 'Login berhasil, anda akan dibawa ke dashboard'])
        @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'title' => 'Data Tidak Valid!', 'message' => 'Login gagal, Akun tidak terdaftar!'])

        <div class="flex bg-white w-fit h-fit md:h-full rounded-3xl overflow-hidden">
            <!-- Gambar di sebelah kiri -->
            <div class="hidden md:block w-1/2">
                <img src="{{ asset('images/auth-image.png') }}" class="object-cover w-full h-full">
            </div>

            <!-- Form login di sebelah kanan -->
            <div class="w-full flex items-center justify-center">
                <div class="w-full p-6">
                    <div class="flex items-center justify-start">
                        <img src="{{ asset('icons/ipaws.svg') }}" class="w-10 h-10 mr-3" alt="iPaws icon">
                        <h1 class="text-3xl font-bold text-gray-800">Login</h1>
                    </div>

                    <p class="text-gray-600 my-6">Halo admin, silahkan masuk dengan akun anda</p>

                    <form id="login-form">
                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" maxlength="100"
                                placeholder="glo@glo.com"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input id="password" type="password" name="password" value="{{ old('password') }}" maxlength="100" 
                                placeholder="************"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500" />
                        </div>

                        <!-- Remember me -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500" />
                                <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" id="submit-button"
                            class="w-full bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                            <span id="submit-button-text">Login</span>
                            <div id="spinner" class="hidden" role="status">
                                <i class="fa-solid fa-spinner animate-spin"></i>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/login.js') }}" defer></script>
</body>

</html>