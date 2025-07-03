@php
    $user = auth()->user();
    $navItems = [
        ['label' => 'Dashboard', 'route' => route('filament.student.pages.dashboard')],
        ['label' => 'Courses', 'route' => route('filament.student.pages.dashboard')],
        ['label' => 'Study material', 'route' => '#'],
        ['label' => 'Profile', 'route' => route('filament.student.pages.profile')],
        ['label' => 'Daily works', 'route' => '#'],
        ['label' => 'Speaking sessions', 'route' => '#'],
        ['label' => 'Doubt clearance', 'route' => '#'],
    ];
    $activeTab = request()->get('tab', 'Home');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rosy's German School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fi-header { display: none !important; }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

<div class="min-h-screen bg-[#F2F3F4] flex flex-col">
    <!-- Sticky Header/Menu: This is the only top bar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 w-full">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('/logo_whitebg.jpeg') }}" alt="Logo" class="h-12 mr-4" style="width: 160px;" />
                </div>
                
                <!-- Desktop Icons -->
                <div class="hidden md:flex items-center space-x-4 lg:space-x-6">
                    <div class="relative">
                        <span class="absolute -top-2 -right-2 px-2 py-0.5 bg-orange-500 text-white text-xs rounded-full">30,931</span>
                        <svg class="w-5 h-5 text-orange-500 cursor-pointer hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="absolute -top-2 -right-2 px-1.5 py-0.5 bg-red-500 text-white text-xs rounded-full">20</span>
                        <svg class="w-5 h-5 text-gray-600 cursor-pointer hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"></path>
                        </svg>
                    </div>
                    <a href="#" class="relative">
                        <svg class="w-5 h-5 text-gray-600 cursor-pointer hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </a>
                    <button class="w-5 h-5 text-gray-600 cursor-pointer hover:text-gray-700">🔍</button>
                    <div class="relative group ml-2">
                        <button id="userMenuButton" class="focus:outline-none">
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full border border-gray-300" />
                        </button>
                        <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-50 border border-gray-100">
                            <a href="{{ route('filament.student.pages.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Icons and Hamburger -->
                <div class="md:hidden flex items-center space-x-3">
                    <div class="relative">
                        <span class="absolute -top-1 -right-1 px-1 py-0 bg-orange-500 text-white text-xs rounded-full text-[10px]">99+</span>
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="absolute -top-1 -right-1 px-1 py-0 bg-red-500 text-white text-xs rounded-full text-[10px]">20</span>
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"></path>
                        </svg>
                    </div>
                    <button id="mobileMenuButton" class="focus:outline-none" onclick="toggleMobileMenu()">
                        <svg id="menu-icon" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex justify-center border-t border-gray-200 mt-2">
                <div class="flex space-x-8 py-2 overflow-x-auto scrollbar-hide">
                    <a href="{{ route('filament.student.pages.dashboard') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.dashboard') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Dashboard</a>
                    <a href="{{ route('filament.student.pages.courses') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.courses') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Courses</a>
                    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Study material</a>
                    <a href="{{ route('filament.student.pages.profile') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.profile') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Profile</a>
                    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Daily works</a>
                    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Speaking sessions</a>
                    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Doubt clearance</a>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 mt-2">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('filament.student.pages.dashboard') }}" class="block px-3 py-2 text-base font-medium {{ request()->routeIs('filament.student.pages.dashboard') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} transition-colors duration-200" onclick="closeMobileMenu()">Dashboard</a>
                    <a href="{{ route('filament.student.pages.courses') }}" class="block px-3 py-2 text-base font-medium {{ request()->routeIs('filament.student.pages.courses') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} transition-colors duration-200" onclick="closeMobileMenu()">Courses</a>
                    <a href="#" class="block px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="closeMobileMenu()">Study material</a>
                    <a href="{{ route('filament.student.pages.profile') }}" class="block px-3 py-2 text-base font-medium {{ request()->routeIs('filament.student.pages.profile') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} transition-colors duration-200" onclick="closeMobileMenu()">Profile</a>
                    <a href="#" class="block px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="closeMobileMenu()">Daily works</a>
                    <a href="#" class="block px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="closeMobileMenu()">Speaking sessions</a>
                    <a href="#" class="block px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="closeMobileMenu()">Doubt clearance</a>
                    
                    <!-- Mobile User Menu -->
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <div class="flex items-center px-3 py-2">
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full border border-gray-300" />
                            <span class="ml-3 text-base font-medium text-gray-700">{{ $user->name }}</span>
                        </div>
                        <a href="{{ route('filament.student.pages.profile') }}" class="block px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="closeMobileMenu()">Profile Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-4 sm:py-6 sm:px-6 lg:px-8 bg-[#FFFFFF] w-full">
        <h1 class="text-lg sm:text-xl md:text-2xl font-semibold text-black mb-4 sm:mb-6 md:mb-8 px-2">
            Welcome to Rosy's German School
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 md:gap-10">
            <!-- See what's going on -->
            <a href="#" class="bg-[#F5F5F5] rounded-lg shadow-sm overflow-hidden transform transition-transform duration-200 hover:scale-[1.02] block">
                <div class="bg-blue-500 p-3 sm:p-4 text-white flex justify-between items-center">
                    <span class="text-sm sm:text-base font-medium">See what's going on</span>
                    <span class="text-lg sm:text-xl cursor-pointer hover:text-blue-100">⋮</span>
                </div>
                <div class="p-4 sm:p-6 flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-blue-100 rounded-lg flex items-center justify-center">
                        <div class="relative">
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-blue-500 transform -rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-blue-500 absolute top-1 left-1 transform rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 sm:mt-4 text-sm sm:text-base text-gray-600 text-center">See what's going on!</p>
                </div>
            </a>

            <!-- German Comics -->
            <a href="#" class="bg-[#F5F5F5] rounded-lg shadow-sm overflow-hidden transform transition-transform duration-200 hover:scale-[1.02] block">
                <div class="bg-green-500 p-3 sm:p-4 text-white flex justify-between items-center">
                    <span class="text-sm sm:text-base font-medium">German Comics</span>
                    <span class="text-lg sm:text-xl cursor-pointer hover:text-green-100">⋮</span>
                </div>
                <div class="p-4 sm:p-6 flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-100 rounded-lg flex items-center justify-center">
                        <div class="relative">
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 sm:mt-4 text-sm sm:text-base text-gray-600 text-center">Comics that cross boundaries, crafted in Germany!</p>
                </div>
            </a>

            <!-- Pre-Recorded Videos -->
            <a href="#" class="bg-[#F5F5F5] rounded-lg shadow-sm overflow-hidden transform transition-transform duration-200 hover:scale-[1.02] block">
                <div class="bg-orange-500 p-3 sm:p-4 text-white flex justify-between items-center">
                    <span class="text-sm sm:text-base font-medium">Pre-Recorded Videos</span>
                    <span class="text-lg sm:text-xl cursor-pointer hover:text-orange-100">⋮</span>
                </div>
                <div class="p-4 sm:p-6 flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 sm:w-12 sm:h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="mt-3 sm:mt-4 text-sm sm:text-base text-gray-600 text-center">Watch, rewatch and never miss a moment!</p>
                </div>
            </a>

            <!-- Take Assessment Test -->
            <a href="#" class="bg-[#F5F5F5] rounded-lg shadow-sm overflow-hidden transform transition-transform duration-200 hover:scale-[1.02] block">
                <div class="bg-teal-500 p-3 sm:p-4 text-white flex justify-between items-center">
                    <span class="text-sm sm:text-base font-medium">Take Assessment Test</span>
                    <span class="text-lg sm:text-xl cursor-pointer hover:text-teal-100">⋮</span>
                </div>
                <div class="p-4 sm:p-6 flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-teal-100 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 sm:w-12 sm:h-12 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <p class="mt-3 sm:mt-4 text-sm sm:text-base text-gray-600 text-center">Test today, triumph tomorrow!</p>
                </div>
            </a>
        </div>
    </main>

    <!-- Separator Section -->
    <div class="bg-gray-200 py-2 w-full"></div>

    <!-- New Design Section -->
    <section class="max-w-7xl mx-auto px-4 py-4 sm:py-6 sm:px-6 lg:px-8 bg-white w-full">
        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
            <div class="flex-1 w-full lg:w-auto">
                <h2 class="text-xl sm:text-2xl font-bold mb-2 sm:mb-4 text-left">Rosy's German School- Linguist Since 1971</h2>
                <p class="text-sm sm:text-base text-gray-600">We Are The Best Choice For Your Dream</p>
            </div>
            <div class="flex-1 w-full lg:w-auto">
                <div class="bg-orange-500 p-4 sm:p-6 text-white rounded-lg">
                    <h3 class="text-base sm:text-lg font-semibold">Profile Completion</h3>
                    <p class="mt-2 text-sm sm:text-base">Profile 80% complete. You are almost done!</p>
                    <a href="{{ route('filament.student.pages.profile') }}" class="mt-3 sm:mt-4 bg-white text-orange-500 px-3 sm:px-4 py-2 rounded inline-block text-sm sm:text-base font-medium hover:bg-gray-50 transition-colors duration-200">Complete Your Profile</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-3 sm:py-4 w-full mt-auto">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0">
            <p class="text-sm sm:text-base">Rocys German Academy</p>
            <p class="text-xs sm:text-sm text-gray-300">Terms & Privacy, © 2025 Copyright</p>
        </div>
    </footer>
</div>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        } else {
            menu.classList.add('hidden');
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
        }
    }
    
    function closeMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');
        menu.classList.add('hidden');
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
    }

    function setActiveTab(tab) {
        const navLinks = document.querySelectorAll('[onclick*="setActiveTab"]');
        navLinks.forEach(link => {
            link.classList.remove('border-cyan-500', 'text-cyan-600', 'bg-cyan-50');
            link.classList.add('border-transparent', 'text-gray-500');
        });
        event.target.classList.remove('border-transparent', 'text-gray-500');
        event.target.classList.add('border-cyan-500', 'text-cyan-600');
        if (event.target.classList.contains('block')) {
            event.target.classList.remove('text-gray-700', 'hover:bg-gray-50', 'hover:text-gray-900');
            event.target.classList.add('bg-cyan-50', 'text-cyan-600');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('userMenuButton');
        const dropdown = document.getElementById('userMenuDropdown');
        if (btn && dropdown) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!btn.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }
    });
</script>

</body>
</html>