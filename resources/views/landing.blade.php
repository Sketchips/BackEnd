<x-app-layout>
    <x-slot name="title">BlueWave - Modern Digital Solutions</x-slot>
    <x-slot name="description">Streamline your business with our modern, efficient digital solutions.</x-slot>

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center bg-gradient-to-r from-blue-800 to-blue-600 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-blue-900 opacity-50"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-900"></div>
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-blue-400/20 via-transparent to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight fade-in">
                    Hidup Jokowi! <span class="text-blue-300">Journey</span>
                </h1>
                <p class="text-xl text-blue-100 mb-8 fade-in" style="transition-delay: 0.2s">
                    Discover the seamless way to transform your business with our intuitive platform designed for the modern world.
                </p>
                <div class="fade-in" style="transition-delay: 0.4s">
                    <a href="#contact" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-8 rounded-md transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Get Started Today
                    </a>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <a href="#about" class="text-white">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 fade-in">About Our Platform</h2>
                <p class="text-xl text-gray-600 fade-in" style="transition-delay: 0.2s">
                    We've created a solution that helps businesses navigate the complexities of the digital landscape with ease and confidence.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="fade-in" style="transition-delay: 0.3s">
                    <div class="rounded-lg overflow-hidden shadow-xl">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                            alt="Team collaboration" class="w-full h-auto">
                    </div>
                </div>

                <div>
                    <div class="space-y-6">
                        <div class="fade-in" style="transition-delay: 0.4s">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-3">Our Mission</h3>
                            <p class="text-gray-600">
                                To empower businesses with intuitive digital tools that simplify complex processes and foster growth in an ever-evolving digital landscape.
                            </p>
                        </div>

                        <div class="fade-in" style="transition-delay: 0.5s">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-3">Why Choose Us?</h3>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>User-friendly interface designed for all skill levels</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Dedicated support team available around the clock</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Continuous updates and improvements based on user feedback</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 fade-in">Powerful Features</h2>
                <p class="text-xl text-gray-600 fade-in" style="transition-delay: 0.2s">
                    Our platform is packed with features designed to help you succeed in today's digital world.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="fade-in" style="transition-delay: 0.3s">
                    <x-feature-card>
                        <x-slot name="icon">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </x-slot>
                        <x-slot name="title">Enhanced Security</x-slot>
                        <x-slot name="description">
                            State-of-the-art security measures to keep your data protected at all times, with regular updates to counter emerging threats.
                        </x-slot>
                    </x-feature-card>
                </div>

                <!-- Feature 2 -->
                <div class="fade-in" style="transition-delay: 0.4s">
                    <x-feature-card>
                        <x-slot name="icon">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </x-slot>
                        <x-slot name="title">Lightning Fast</x-slot>
                        <x-slot name="description">
                            Optimized for speed and performance, our platform ensures you can work efficiently without frustrating delays or downtime.
                        </x-slot>
                    </x-feature-card>
                </div>

                <!-- Feature 3 -->
                <div class="fade-in" style="transition-delay: 0.5s">
                    <x-feature-card>
                        <x-slot name="icon">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        </x-slot>
                        <x-slot name="title">Cloud Integration</x-slot>
                        <x-slot name="description">
                            Seamlessly connect with popular cloud services, allowing you to access your work from anywhere, on any device.
                        </x-slot>
                    </x-feature-card>
                </div>

                <!-- Feature 4 -->
                <div class="fade-in" style="transition-delay: 0.6s">
                    <x-feature-card>
                        <x-slot name="icon">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </x-slot>
                        <x-slot name="title">Team Collaboration</x-slot>
                        <x-slot name="description">
                            Built-in tools for team communication and project management, making collaboration effortless regardless of location.
                        </x-slot>
                    </x-feature-card>
                </div>

                <!-- Feature 5 -->
                <div class="fade-in" style="transition-delay: 0.7s">
                    <x-feature-card>
                        <x-slot name="icon">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </x-slot>
                        <x-slot name="title">Advanced Analytics</x-slot>
                        <x-slot name="description">
                            Gain valuable insights with comprehensive analytics and reporting tools that help you make data-driven decisions.
                        </x-slot>
                    </x-feature-card>
                </div>

                <!-- Feature 6 -->
                <div class="fade-in" style="transition-delay: 0.8s">
                    <x-feature-card>
                        <x-slot name="icon">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </x-slot>
                        <x-slot name="title">Customizable Interface</x-slot>
                        <x-slot name="description">
                            Tailor the platform to your specific needs with extensive customization options and a flexible, adaptable interface.
                        </x-slot>
                    </x-feature-card>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section id="testimonials" class="py-20 bg-blue-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 fade-in">What Our Clients Say</h2>
                <p class="text-xl text-gray-600 fade-in" style="transition-delay: 0.2s">
                    Don't just take our word for it — hear from some of our satisfied customers.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="fade-in" style="transition-delay: 0.3s">
                    <x-testimonial-card
                        name="Sarah Johnson"
                        position="Marketing Director"
                        rating="5"
                        image="https://randomuser.me/api/portraits/women/45.jpg"
                        quote="BlueWave transformed our marketing operations. The intuitive interface and powerful analytics have significantly improved our campaign effectiveness. Their support team is also exceptional!" />
                </div>

                <!-- Testimonial 2 -->
                <div class="fade-in" style="transition-delay: 0.4s">
                    <x-testimonial-card
                        name="David Chen"
                        position="CTO, TechSolutions Inc"
                        rating="4"
                        image="https://randomuser.me/api/portraits/men/32.jpg"
                        quote="As a tech company, we have high standards for the tools we use. BlueWave exceeded our expectations with its robust security features and seamless cloud integration capabilities." />
                </div>

                <!-- Testimonial 3 -->
                <div class="fade-in" style="transition-delay: 0.5s">
                    <x-testimonial-card
                        name="Emily Rodriguez"
                        position="Small Business Owner"
                        rating="5"
                        image="https://randomuser.me/api/portraits/women/28.jpg"
                        quote="BlueWave has been a game-changer for my small business. It's affordable, easy to use, and has features that I previously thought were only available to larger enterprises." />
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6 fade-in">Ready to Transform Your Business?</h2>
                <p class="text-xl text-blue-100 mb-8 fade-in" style="transition-delay: 0.2s">
                    Join thousands of satisfied customers who are already enjoying the benefits of our platform.
                </p>
                <div class="max-w-md mx-auto">
                    <form class="space-y-4 fade-in" style="transition-delay: 0.3s">
                        <div>
                            <input type="email" placeholder="Enter your email" class="w-full px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300 text-gray-800">
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-white text-blue-600 hover:bg-blue-50 font-medium py-3 px-6 rounded-md transition-colors duration-300 shadow-lg hover:shadow-xl">
                                Get Started For Free
                            </button>
                        </div>
                    </form>
                    <p class="mt-4 text-sm text-blue-200 fade-in" style="transition-delay: 0.4s">
                        No credit card required. Start your 14-day free trial today.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>