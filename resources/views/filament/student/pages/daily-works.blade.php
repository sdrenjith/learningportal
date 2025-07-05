@php
    $viewData = $this->getViewData();
    $user = $viewData['user'];
    $assignedCourses = $viewData['assignedCourses'];
    $assignedDays = $viewData['assignedDays'];
    $answeredQuestionIds = $viewData['answeredQuestionIds'];
    $activeDay = $viewData['activeDay'];
    $activeDayQuestions = $viewData['activeDayQuestions'];
@endphp

<x-filament-panels::page>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .fi-header { display: none !important; }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    
    <div class="bg-gray-50">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 flex flex-col">
        <!-- Enhanced Navigation Header -->
        <nav class="bg-white shadow-sm sticky top-0 z-50 w-full border-b border-gray-100">
            <div class="w-full max-w-[120rem] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="{{ asset('/logo_whitebg.jpeg') }}" alt="Logo" class="h-10 sm:h-12 mr-4" style="width: 140px;" />
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        
                        <!-- User Menu -->
                        <div class="relative group">
                            <button id="userMenuButton" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full border-2 border-gray-200" />
                                <span class="text-sm font-medium">{{ $user->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                                <a href="{{ route('filament.student.pages.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button id="mobileMenuButton" class="text-gray-600 hover:text-gray-900 focus:outline-none" onclick="toggleMobileMenu()">
                            <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex justify-center border-t border-gray-100 py-3">
                    <div class="flex space-x-8">
                        <a href="{{ route('filament.student.pages.dashboard') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.dashboard') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700' }} px-3 py-2 transition-colors duration-200">Dashboard</a>
                        <a href="{{ route('filament.student.pages.courses') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.courses') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700' }} px-3 py-2 transition-colors duration-200">Courses</a>
                        <a href="{{ route('filament.student.pages.study-materials') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.study-materials') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700' }} px-3 py-2 transition-colors duration-200">Study Materials</a>
                        <a href="{{ route('filament.student.pages.profile') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.profile') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700' }} px-3 py-2 transition-colors duration-200">Profile</a>
                        <a href="{{ route('filament.student.pages.daily-works') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.daily-works') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700' }} px-3 py-2 transition-colors duration-200">Daily Works</a>
                        <a href="{{ route('filament.student.pages.speaking-sessions') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.speaking-sessions') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700' }} px-3 py-2 transition-colors duration-200">Speaking Sessions</a>
                        <a href="{{ route('filament.student.pages.doubt-clearance') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.doubt-clearance') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700' }} px-3 py-2 transition-colors duration-200">Doubt Clearance</a>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
                <div class="px-4 py-3 space-y-2">
                    <a href="{{ route('filament.student.pages.dashboard') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('filament.student.pages.dashboard') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} rounded-lg transition-all duration-200" onclick="closeMobileMenu()">Dashboard</a>
                    <a href="{{ route('filament.student.pages.courses') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('filament.student.pages.courses') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} rounded-lg transition-all duration-200" onclick="closeMobileMenu()">Courses</a>
                    <a href="{{ route('filament.student.pages.study-materials') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('filament.student.pages.study-materials') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} rounded-lg transition-all duration-200" onclick="closeMobileMenu()">Study Materials</a>
                    <a href="{{ route('filament.student.pages.profile') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('filament.student.pages.profile') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} rounded-lg transition-all duration-200" onclick="closeMobileMenu()">Profile</a>
                    <a href="{{ route('filament.student.pages.daily-works') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('filament.student.pages.daily-works') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} rounded-lg transition-all duration-200" onclick="closeMobileMenu()">Daily Works</a>
                    <a href="{{ route('filament.student.pages.speaking-sessions') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('filament.student.pages.speaking-sessions') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} rounded-lg transition-all duration-200" onclick="closeMobileMenu()">Speaking Sessions</a>
                    <a href="{{ route('filament.student.pages.doubt-clearance') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('filament.student.pages.doubt-clearance') ? 'text-cyan-600 bg-cyan-50 border-l-4 border-cyan-500' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} rounded-lg transition-all duration-200" onclick="closeMobileMenu()">Doubt Clearance</a>
                    
                    <!-- Mobile User Menu -->
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex items-center px-4 py-3 bg-gray-50 rounded-lg mb-2">
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full border-2 border-gray-200" />
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-base font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 w-full">
            <div class="w-full max-w-[120rem] mx-auto px-4 py-6 sm:py-8 sm:px-6 lg:px-8">
                <!-- Page Header -->
                <div class="mb-8 sm:mb-10">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                📝 Daily Works
                            </h1>
                            <p class="text-gray-600 text-base sm:text-lg" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                Complete your daily assignments and track your progress
                            </p>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ \Carbon\Carbon::now()->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

            @if($activeDay)
                <!-- Active Day Header -->
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 text-white">
                        <h2 class="text-2xl font-bold mb-2">{{ $activeDay->title }}</h2>
                        <p class="text-blue-100">{{ $activeDay->course->name ?? 'Current Active Day' }}</p>
                        <div class="mt-4 flex items-center">
                            @php
                                $totalQuestions = $activeDayQuestions->count();
                                $answeredCount = $activeDayQuestions->filter(function($q) use ($answeredQuestionIds) {
                                    return in_array($q->id, $answeredQuestionIds);
                                })->count();
                                $progress = $totalQuestions > 0 ? ($answeredCount / $totalQuestions) * 100 : 0;
                            @endphp
                            <div class="flex-1 bg-white bg-opacity-20 rounded-full h-2 mr-4">
                                <div class="bg-white h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                            </div>
                            <span class="text-sm font-medium">{{ $answeredCount }}/{{ $totalQuestions }} completed</span>
                        </div>
                    </div>
                </div>

                <!-- Questions for Active Day -->
                @if($activeDayQuestions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($activeDayQuestions->groupBy('subject_id') as $subjectId => $subjectQuestions)
                            @php
                                $subject = $subjectQuestions->first()->subject;
                                $subjectAnsweredCount = $subjectQuestions->filter(function($q) use ($answeredQuestionIds) {
                                    return in_array($q->id, $answeredQuestionIds);
                                })->count();
                                $subjectProgress = $subjectQuestions->count() > 0 ? ($subjectAnsweredCount / $subjectQuestions->count()) * 100 : 0;
                            @endphp
                            
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $subject->name }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subjectProgress == 100 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $subjectAnsweredCount }}/{{ $subjectQuestions->count() }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                            <span>Progress</span>
                                            <span>{{ round($subjectProgress) }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" style="width: {{ $subjectProgress }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        @foreach($subjectQuestions as $question)
                                            @php
                                                $isAnswered = in_array($question->id, $answeredQuestionIds);
                                            @endphp
                                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <div class="flex items-center">
                                                    <div class="w-6 h-6 rounded-full flex items-center justify-center {{ $isAnswered ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                                        @if($isAnswered)
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        @else
                                                            <span class="text-xs">{{ $loop->iteration }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium text-gray-900">Question {{ $loop->iteration }}</p>
                                                        <p class="text-xs text-gray-500">{{ $question->questionType->name ?? 'Question' }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    @if($isAnswered)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Completed
                                                        </span>
                                                    @endif
                                                    <a href="{{ route('student.questions.answer', $question->id) }}" 
                                                       class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white {{ $isAnswered ? 'bg-orange-500 hover:bg-orange-600' : 'bg-blue-600 hover:bg-blue-700' }} transition-colors duration-200">
                                                        {{ $isAnswered ? 'Re-attempt' : 'Start' }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="mx-auto h-12 w-12 text-gray-400">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m-16-4c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252"></path>
                            </svg>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No questions available</h3>
                        <p class="mt-1 text-sm text-gray-500">There are no questions assigned for this day yet.</p>
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No active day</h3>
                    <p class="mt-1 text-sm text-gray-500">No days have been assigned to your batch yet.</p>
                </div>
            @endif
            </div>
        </main>

        <!-- Separator Section -->
        <div class="bg-gray-200 py-2 w-full"></div>

        <!-- New Design Section -->
        <section class="w-full bg-white">
            <div class="w-full max-w-[120rem] mx-auto px-4 py-4 sm:py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
                <div class="flex-1 w-full lg:w-auto">
                    <h2 class="text-xl sm:text-2xl font-bold mb-2 sm:mb-4 text-left">Rosy's German School- Linguist Since 1971</h2>
                    <p class="text-sm sm:text-base text-gray-600">We Are The Best Choice For Your Dream</p>
                </div>
                <div class="flex-1 w-full lg:w-auto">
                    @php
                        // Calculate overall progress for Daily Works
                        $assignedCourseIds = $assignedCourses->pluck('id')->toArray();
                        $assignedDayIds = $assignedDays->pluck('id')->toArray();
                        
                        $totalQuestions = \App\Models\Question::whereIn('course_id', $assignedCourseIds)
                            ->whereIn('day_id', $assignedDayIds)
                            ->where('is_active', true)
                            ->count();
                        
                        $answeredQuestions = \App\Models\StudentAnswer::where('user_id', $user->id)
                            ->whereHas('question', function($q) use ($assignedCourseIds, $assignedDayIds) {
                                $q->whereIn('course_id', $assignedCourseIds)
                                  ->whereIn('day_id', $assignedDayIds)
                                  ->where('is_active', true);
                            })
                            ->count();
                        
                        $progressPercentage = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
                        
                        // Motivational message based on progress
                        $motivationalMessage = '';
                        if ($progressPercentage >= 90) {
                            $motivationalMessage = "🎉 Almost there! You're doing amazing!";
                        } elseif ($progressPercentage >= 75) {
                            $motivationalMessage = "🚀 Great progress! Keep it up!";
                        } elseif ($progressPercentage >= 50) {
                            $motivationalMessage = "💪 You're halfway there!";
                        } elseif ($progressPercentage >= 25) {
                            $motivationalMessage = "📚 Good start! Keep learning!";
                        } else {
                            $motivationalMessage = "🌟 Every question counts!";
                        }
                    @endphp
                    <div class="bg-orange-500 p-4 sm:p-6 text-white rounded-lg">
                        <h3 class="text-base sm:text-lg font-semibold">Course Progress</h3>
                        <p class="mt-2 text-sm sm:text-base">{{ $answeredQuestions }}/{{ $totalQuestions }} questions completed ({{ $progressPercentage }}%)</p>
                        <div class="w-full bg-orange-400 rounded-full h-2 mt-3 mb-3">
                            <div class="bg-white h-2 rounded-full transition-all duration-300" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <p class="text-sm mb-3">{{ $motivationalMessage }}</p>
                        <a href="{{ route('filament.student.pages.courses') }}" class="mt-3 sm:mt-4 bg-white text-orange-500 px-3 sm:px-4 py-2 rounded inline-block text-sm sm:text-base font-medium hover:bg-gray-50 transition-colors duration-200">Continue Learning</a>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <!-- Enhanced Footer -->
        <div class="bg-gradient-to-r from-gray-100 to-gray-200 py-1 w-full"></div>
        <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-6 sm:py-8 w-full mt-auto">
            <div class="w-full max-w-[120rem] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
                    <div class="text-center sm:text-left">
                        <p class="text-lg sm:text-xl font-semibold">Rosy's German Academy</p>
                        <p class="text-sm text-gray-300 mt-1">Empowering German language learning</p>
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-sm text-gray-300">© 2025 All rights reserved</p>
                        <p class="text-xs text-gray-400 mt-1">Terms & Privacy Policy</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>

    <!-- Student Watermark -->
    <x-student-watermark />

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
</x-filament-panels::page> 