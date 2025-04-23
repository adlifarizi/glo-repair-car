<!-- resources/views/components/admin-header.blade.php -->
<div class="p-4 bg-red-700 flex items-center justify-between text-white" x-data="{ adminName: localStorage.getItem('admin_name') || 'admin' }">
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
    <p x-text="`Halo, ${adminName}`"></p>
</div>