<nav id="navbar" class="fixed w-full z-50 bg-black md:bg-transparent transition-all duration-300">
    <div class="max-w-7xl mx-auto py-3">
        <div class="flex items-center justify-start md:justify-center">

            <!-- Desktop Menu -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="{{ url('/') }}"
                        class="{{ request()->is('/') ? 'text-red-500' : 'text-white hover:text-red-500' }} font-medium px-3 py-2 rounded-md text-base transition-colors duration-200">
                        Beranda
                    </a>
                    <a href="{{ url('layanan') }}"
                        class="{{ request()->is('layanan') ? 'text-red-500' : 'text-white hover:text-red-500' }} font-medium px-3 py-2 rounded-md text-base transition-colors duration-200">
                        Layanan
                    </a>
                    <a href="{{ url('ulasan') }}"
                        class="{{ request()->is('ulasan') ? 'text-red-500' : 'text-white hover:text-red-500' }} font-medium px-3 py-2 rounded-md text-base transition-colors duration-200">
                        Ulasan
                    </a>
                    <a href="{{ url('kontak') }}"
                        class="{{ request()->is('kontak') ? 'text-red-500' : 'text-white hover:text-red-500' }} font-medium px-3 py-2 rounded-md text-base transition-colors duration-200">
                        Kontak
                    </a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden ">
                <button type="button" onclick="toggleMobileMenu()"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-red-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path id="mobile-menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="hidden md:hidden bg-black bg-opacity-90" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ url('/') }}"
                class="{{ request()->is('/') ? 'text-red-500' : 'text-white hover:text-red-500' }} block px-3 py-2 rounded-md text-base font-medium">
                Beranda
            </a>
            <a href="{{ url('layanan') }}"
                class="{{ request()->is('layanan') ? 'text-red-500' : 'text-white hover:text-red-500' }} block px-3 py-2 rounded-md text-base font-medium">
                Layanan
            </a>
            <a href="{{ url('ulasan') }}"
                class="{{ request()->is('ulasan') ? 'text-red-500' : 'text-white hover:text-red-500' }} block px-3 py-2 rounded-md text-base font-medium">
                Ulasan
            </a>
            <a href="{{ url('kontak') }}"
                class="{{ request()->is('kontak') ? 'text-red-500' : 'text-white hover:text-red-500' }} block px-3 py-2 rounded-md text-base font-medium">
                Kontak
            </a>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuIcon = document.getElementById('mobile-menu-icon');

        if (mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.remove('hidden');
            mobileMenuIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12'); // X icon
        } else {
            mobileMenu.classList.add('hidden');
            mobileMenuIcon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16'); // Hamburger icon
        }
    }

    window.addEventListener("scroll", function () {
        const navbar = document.getElementById("navbar");
        if (window.scrollY > 10) { // Jika scroll lebih dari 10px
            if (window.innerWidth < 768) { // Mobile
                navbar.classList.remove("bg-transparent");
                navbar.classList.add("bg-black");
            } else { // Desktop
                navbar.classList.remove("md:bg-transparent");
                navbar.classList.add("md:bg-black");
            }
        } else {
            if (window.innerWidth < 768) { // Mobile
                navbar.classList.remove("bg-transparent");
                navbar.classList.add("bg-black");
            } else { // Desktop
                navbar.classList.add("md:bg-transparent");
                navbar.classList.remove("md:bg-black");
            }
        }
    });
</script>