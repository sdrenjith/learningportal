@php
    $user = auth()->user();
    $firstUnansweredFound = false;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Rosy's German School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
                    <img src="{{ asset('/logo_whitebg.jpeg') }}" alt="Logo" class="h-8 sm:h-10 md:h-12 mr-2 sm:mr-4 w-32 sm:w-44 md:w-52" />
                </div>
                
                <!-- Desktop Icons -->
                <div class="hidden md:flex items-center space-x-4 lg:space-x-6">
                    <div class="relative">
                        <span class="absolute -top-2 -right-2 px-1.5 sm:px-2 py-0.5 bg-orange-500 text-white text-xs rounded-full">30,931</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500 cursor-pointer hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="absolute -top-2 -right-2 px-1.5 py-0.5 bg-red-500 text-white text-xs rounded-full">20</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600 cursor-pointer hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"></path>
                        </svg>
                    </div>
                    <a href="#" class="relative">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600 cursor-pointer hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </a>
                    <button class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600 cursor-pointer hover:text-gray-700">🔍</button>
                    <div class="relative group ml-2">
                        <button id="userMenuButton" class="focus:outline-none">
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" alt="{{ $user->name }}" class="h-6 w-6 sm:h-8 sm:w-8 rounded-full border border-gray-300" />
                        </button>
                        <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-50 border border-gray-100">
                            <a href="{{ route('filament.student.pages.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
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
                <div class="flex space-x-4 lg:space-x-8 py-2 overflow-x-auto scrollbar-hide">
                    <a href="{{ route('filament.student.pages.dashboard') }}" class="text-sm lg:text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Dashboard</a>
                    <a href="{{ route('filament.student.pages.courses') }}" class="text-sm lg:text-base font-medium text-cyan-600 border-b-2 border-cyan-500 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Courses</a>
                    <a href="#" class="text-sm lg:text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Study material</a>
                    <a href="{{ route('filament.student.pages.profile') }}" class="text-sm lg:text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Profile</a>
                    <a href="#" class="text-sm lg:text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Daily works</a>
                    <a href="#" class="text-sm lg:text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Speaking sessions</a>
                    <a href="#" class="text-sm lg:text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200 whitespace-nowrap">Doubt clearance</a>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 mt-2">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('filament.student.pages.dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="closeMobileMenu()">Dashboard</a>
                    <a href="{{ route('filament.student.pages.courses') }}" class="block px-3 py-2 text-base font-medium text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500 transition-colors duration-200" onclick="closeMobileMenu()">Courses</a>
                    <a href="#" class="block px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="closeMobileMenu()">Study material</a>
                    <a href="{{ route('filament.student.pages.profile') }}" class="block px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="closeMobileMenu()">Profile</a>
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
            Available Courses
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 md:gap-10 mb-8 sm:mb-12">
            @forelse($courses as $course)
                <a href="#" class="bg-[#F5F5F5] rounded-lg shadow-sm overflow-hidden transform transition-transform duration-200 hover:scale-[1.02] block">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 p-3 sm:p-4 text-white flex justify-between items-center">
                        <span class="text-sm sm:text-base font-medium">{{ $course->name }}</span>
                        <span class="text-lg sm:text-xl cursor-pointer hover:text-cyan-100">⋮</span>
                    </div>
                    <div class="p-4 sm:p-6 flex flex-col items-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <p class="mt-3 sm:mt-4 text-sm sm:text-base text-gray-600 text-center">{{ $course->description ?? 'Enhance your German language skills!' }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full">
                    <div class="bg-[#F5F5F5] rounded-lg shadow-sm p-8 sm:p-12 text-center">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-600 mb-2">No Courses Available</h3>
                        <p class="text-sm sm:text-base text-gray-500">New courses will be available soon. Check back later!</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Course Structure Explorer -->
        @if($courses->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 text-cyan-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Course Structure
                </h2>
                <p class="text-gray-600 mt-1">Explore the detailed structure of each course</p>
            </div>
            
            <div class="p-6">
                @forelse($courses as $course)
                    <div x-data="{ open: false }" class="mb-4 last:mb-0">
                        <!-- Course Header -->
                        <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border border-cyan-200 hover:border-cyan-300 transition-colors duration-200">
                            <button @click="open = !open" class="w-full px-6 py-4 text-left focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-opacity-50 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800">{{ $course->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $course->description ?? 'Course curriculum and daily structure' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-cyan-600 transform transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </button>
                        </div>

                        <!-- Course Content -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="mt-4 ml-4 space-y-3">
                            @forelse($course->days->filter(fn($day) => $day->questions->count() > 0) as $day)
                                @php
                                    $totalQuestions = $day->questions->count();
                                    $completedQuestions = $day->questions->filter(fn($q) => in_array($q->id, $answeredQuestionIds ?? []))->count();
                                @endphp
                                <div x-data="{ openDay: false }" class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <!-- Day Header -->
                                    <button @click="openDay = !openDay" class="w-full px-5 py-3 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-xs font-bold text-white">{{ $loop->iteration }}</span>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-800">{{ $day->title ?? 'Day ' . $day->id }} <span class="text-xs text-gray-500 font-normal">({{ $completedQuestions }}/{{ $totalQuestions }} completed)</span></h4>
                                                    <p class="text-sm text-gray-500">{{ $totalQuestions }} questions</p>
                                                </div>
                                            </div>
                                            <svg class="w-4 h-4 text-blue-600 transform transition-transform duration-200" :class="openDay ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </button>

                                    <!-- Day Content -->
                                    <div x-show="openDay" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="px-5 pb-3">
                                        <div class="border-t border-gray-100 pt-3">
                                            @forelse($day->questions as $question)
                                                @php
                                                    $answered = in_array($question->id, $answeredQuestionIds ?? []);
                                                    $disableButton = !$answered && $firstUnansweredFound;
                                                    if (!$answered && !$firstUnansweredFound) {
                                                        $firstUnansweredFound = true;
                                                    }
                                                @endphp
                                                <div class="flex items-center mb-1 space-x-2 justify-between bg-gray-50 rounded px-3 py-2">
                                                    <span class="truncate flex-1">{{ \Illuminate\Support\Str::limit($question->instruction ?? 'No question text', 60) }}</span>
                                                    @if($answered)
                                                        <span class="ml-2 text-green-600 flex items-center text-xs font-semibold">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            Answered
                                                        </span>
                                                    @endif
                                                    <a href="{{ route('student.questions.answer', $question->id) }}" target="_blank"
                                                       class="ml-2 px-4 py-1.5 text-xs font-semibold rounded transition focus:outline-none
                                                              {{ $answered ? 'bg-green-100 text-green-700 hover:bg-green-200' : ($disableButton ? 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none' : 'bg-cyan-500 text-white hover:bg-cyan-600') }}"
                                                       {{ $disableButton ? 'tabindex="-1" aria-disabled="true"' : '' }}>
                                                        {{ $answered ? 'View' : 'Answer' }}
                                                    </a>
                                                    @if($answered)
                                                        <a href="{{ route('student.questions.answer', $question->id) }}?edit=1" target="_blank"
                                                           class="ml-2 px-4 py-1.5 text-xs font-semibold rounded transition focus:outline-none bg-yellow-100 text-yellow-800 hover:bg-yellow-200">
                                                            Edit
                                                        </a>
                                                    @endif
                                                </div>
                                            @empty
                                                <div class="text-center py-4">
                                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <p class="text-sm text-gray-500">No questions available for this day</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4M8 7h8M8 7l-2 9a2 2 0 002 2h4a2 2 0 002-2l-2-9"></path>
                                    </svg>
                                    <p class="text-gray-500 font-medium">No days configured for this course</p>
                                    <p class="text-sm text-gray-400 mt-1">Days and content will be added soon</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">No Courses Available</h3>
                        <p class="text-gray-500">Course structure will appear here once courses are added</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endif
    </main>

    <!-- Separator Section -->
    <div class="bg-gray-200 py-2 w-full"></div>

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