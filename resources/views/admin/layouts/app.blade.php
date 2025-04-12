<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!-- Poppins Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;800;900&display=swap"
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

    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    <!-- Styles / Scripts -->
    @vite('resources/css/app.css')

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="flex" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Mobile (Overlay) -->
    <div class="fixed inset-0 z-50 flex md:hidden" x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black opacity-50" @click="sidebarOpen = false"></div>

        <!-- Sidebar panel -->
        <div class="relative w-64 bg-white shadow-lg z-50">
            @include('admin.components.sidebar')
        </div>
    </div>

    <!-- Sidebar Desktop -->
    <div class="hidden md:block">
        @include('admin.components.sidebar')
    </div>

    <!-- Main Content -->
    <div class="flex-1 min-w-0">
        <div class="flex flex-col bg-[#F2F2F2] min-h-screen">
            <!-- Header -->
            <div class="p-4 bg-red-700 flex items-center justify-between text-white">
                <!-- Hamburger Button (mobile only) -->
                <button class="md:hidden" @click="sidebarOpen = true">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Title (hidden on mobile) -->
                <div class="flex-col gap-2 hidden md:flex">
                    <p class="text-red-300">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMM, HH.mm') }}
                    </p>
                    <p>Glo Repair Car Admin Site</p>
                </div>

                <!-- Right side -->
                <p>Halo, admin</p>
            </div>

            <!-- Page Content -->
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

</body>

</html>