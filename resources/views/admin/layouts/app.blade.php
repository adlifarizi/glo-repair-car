<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            encrypted: true
        });
    </script>

    <!-- Global Javascript -->
    <script src="{{ asset('js/admin/app.js') }}" defer></script>
</head>

<script>
    $(document).ready(function () {
        const hasToken = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');

        if (!hasToken) {
            // Jika tidak ada token, arahkan kembali ke login
            window.location.href = window.location.origin + "/login";
        }
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + (localStorage.getItem('access_token') || sessionStorage.getItem('access_token'))
        }
    });
</script>

<body class="flex" x-data="{ sidebarOpen: false }">

    <!-- Dialog -->
    @include('admin.components.dialog', ['id' => 'dialog-confirm-logout', 'show' => false, 'type' => 'confirm-logout', 'message' => 'Anda yakin ingin logout?'])

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
    <div class="flex-1 min-w-0 bg-[#F2F2F2]">
        @yield('content')
    </div>

</body>

</html>