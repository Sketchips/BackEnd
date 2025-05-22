<x-slot name="styles">
    <style>
        .navbar-active {
            opacity: 0.9;
            border-bottom: 1px solid rgba(219, 234, 254, 0.1);
        }
    </style>
</x-slot>

<nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-white">
                    <span class="text-blue-300">Blue</span>Wave
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#about" class="text-white hover:text-blue-300 transition-colors duration-300">About</a>
                <a href="#features" class="text-white hover:text-blue-300 transition-colors duration-300">Features</a>
                <a href="#testimonials" class="text-white hover:text-blue-300 transition-colors duration-300">Testimonials</a>
                <a href="#contact" class="text-white hover:text-blue-300 transition-colors duration-300">Contact</a>
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-md transition-colors duration-300">Get Started</a>
            </div>

            <!-- Mobile Navigation Toggle -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-blue-900 rounded-lg mt-2 p-4 transform origin-top transition-all duration-300 ease-in-out">
            <div class="flex flex-col space-y-4">
                <a href="#about" class="text-white hover:text-blue-300 transition-colors duration-300">About</a>
                <a href="#features" class="text-white hover:text-blue-300 transition-colors duration-300">Features</a>
                <a href="#testimonials" class="text-white hover:text-blue-300 transition-colors duration-300">Testimonials</a>
                <a href="#contact" class="text-white hover:text-blue-300 transition-colors duration-300">Contact</a>
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-md transition-colors duration-300 text-center">Get Started</a>
            </div>
        </div>
    </div>
</nav>

<x-slot name="scripts">
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Navbar background change on scroll
        const navbar = document.getElementById('navbar');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-blue-900', 'navbar-active');
            } else {
                navbar.classList.remove('bg-blue-900', 'navbar-active');
            }
        });
    </script>
</x-slot>