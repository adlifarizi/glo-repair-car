@php 
    $menuItems = [
        ['name' => 'Dashboard', 'icon' => "admin.icon.nav-dashboard", 'route' => '/dashboard'],
        ['name' => 'Kelola Entri Servis', 'icon' => "admin.icon.nav-entri", 'route' => '/kelola-entri-servis'],
        ['name' => 'Kelola Ulasan', 'icon' => "admin.icon.nav-ulasan", 'route' => '/'],
        ['name' => 'Kelola Chat Pelanggan', 'icon' => "admin.icon.nav-chat", 'route' => '/'],
        ['name' => 'Kelola Maps', 'icon' => "admin.icon.nav-maps", 'route' => '/'],
        ['name' => 'Kelola Kontak', 'icon' => "admin.icon.nav-kontak", 'route' => '/'],
        ['name' => 'Kelola Pemasukan', 'icon' => "admin.icon.nav-pemasukan", 'route' => '/'],
        ['name' => 'Kelola Pengeluaran', 'icon' => "admin.icon.nav-pengeluaran", 'route' => '/'],
    ];
@endphp

<div class="min-h-screen z-50 bg-white overflow-hidden transition-all duration-300 w-64 md:w-fit md:hover:w-64 group">
    <!-- Logo -->
    <div class="flex flex-row items-center gap-2 justify-center px-4 h-20 transition-all duration-500">
        <img src="{{ asset('icons/ipaws.svg') }}" class="w-10 h-10" alt="iPaws">
        <div class="flex flex-col mt-2 md:hidden">
            <p class="text-red-500 font-semibold w-fit whitespace-nowrap overflow-hidden">SIMBA</p>
            <p class="text-gray-500 text-xs w-fit whitespace-nowrap overflow-hidden">Sistem Informasi Manajemen<br> Bengkel dan Administrasi</p>
        </div>
        <div class="hidden md:group-hover:flex md:group-hover:flex-col mt-2">
            <p class="text-red-500 font-semibold hidden md:group-hover:inline w-fit whitespace-nowrap overflow-hidden animate-typing">SIMBA</p>
            <p class="text-gray-500 text-xs w-fit whitespace-nowrap overflow-hidden animate-typing">Sistem Informasi Manajemen<br> Bengkel dan Administrasi</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex flex-col items-start justify-center transition-all duration-300 space-y-1 mt-2 px-4">
        @foreach ($menuItems as $item)
                @php
                    $isActive = request()->is(ltrim($item['route'], '/'));
                @endphp

                <a href="{{ url($item['route']) }}"
                    class="flex items-center text-xl font-medium w-full px-2 py-2 transition-all duration-200 
                        {{ $isActive ? 'text-red-700 md:group-hover:bg-red-200' : 'text-gray-500 hover:text-red-700' }}">

                    <span class="text-xl text-center">
                        <x-dynamic-component :component="$item['icon']" />
                    </span>

                    <span class="ml-4 block text-sm transition-opacity duration-300 whitespace-nowrap md:hidden">
                        {{ $item['name'] }}
                    </span>
                    <span class="ml-4 hidden md:group-hover:block text-sm transition-opacity duration-300 whitespace-nowrap">
                        {{ $item['name'] }}
                    </span>
                </a>
        @endforeach

        <!-- Logout -->
        <form method="POST">
            @csrf
            <button type="submit" class="flex items-center justify-start px-2 py-2 text-red-500 font-medium hover:text-red-600 transition-all duration-200">
                <x-admin.icon.nav-logout class="text-lg text-center" />
                <span class="ml-4 block text-sm md:hidden">Logout</span>
                <span class="ml-4 hidden md:group-hover:block text-sm">Logout</span>
            </button>
        </form>
    </nav>
</div>