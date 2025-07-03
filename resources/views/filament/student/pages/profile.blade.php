<style>
.fi-header { display: none !important; }
</style>

@php
    $user = auth()->user();
@endphp

<x-filament-panels::page>
    <div class="min-h-screen bg-[#F2F3F4] flex flex-col">
        <!-- Sticky Header/Menu: This is the only top bar -->
        <nav class="bg-white shadow-sm sticky top-0 z-50 w-full">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <img src="{{ asset('/logo_whitebg.jpeg') }}" alt="Logo" class="h-12 mr-4" style="width: 160px;" />
                    </div>
                    <div class="flex items-center space-x-6">
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
                                <img src="{{ filament()->getUserAvatarUrl($user) }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full border border-gray-300" />
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
                </div>
                <div class="flex justify-center border-t border-gray-200 mt-2">
                    <div class="flex space-x-8 py-2">
                        <a href="{{ route('filament.student.pages.dashboard') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.dashboard') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} px-2 pb-1 transition-colors duration-200">Dashboard</a>
                        <a href="{{ route('filament.student.pages.courses') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.courses') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} px-2 pb-1 transition-colors duration-200">Courses</a>
                        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200">Study material</a>
                        <a href="{{ route('filament.student.pages.profile') }}" class="text-base font-medium {{ request()->routeIs('filament.student.pages.profile') ? 'text-cyan-600 border-b-2 border-cyan-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} px-2 pb-1 transition-colors duration-200">Profile</a>
                        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200">Daily works</a>
                        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200">Speaking sessions</a>
                        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 px-2 pb-1 transition-colors duration-200">Doubt clearance</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="max-w-5xl w-full bg-white rounded-xl shadow-md flex flex-col md:flex-row p-8 gap-8 mx-auto mt-10">
            <!-- Profile Card FIRST for mobile -->
            <div class="w-full md:w-80 bg-[#f7f7f7] rounded-xl flex flex-col items-center py-8 px-4 shadow-sm relative text-black mb-8 md:mb-0">
                <span class="absolute -top-4 left-1/2 -translate-x-1/2 bg-yellow-400 text-xs font-semibold px-4 py-1 rounded-full border-2 border-white shadow text-black">Profile</span>
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/120' }}" alt="Profile" class="rounded-full border-4 border-yellow-400 w-28 h-28 object-cover mb-3 mt-4" />
                <div class="text-lg font-bold text-black mt-2">{{ $user->name }}</div>
                <div class="flex items-center text-gray-700 mb-1 mt-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>{{ $user->phone ?? '+50 123 456 7890' }}</span>
                </div>
                <div class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>{{ $user->email }}</span>
                </div>
            </div>
            <!-- Details -->
            <div class="flex-1 text-black">
                <h2 class="text-2xl font-bold mb-6 text-black">Personal Information</h2>
                <div class="mb-8 bg-white rounded-lg shadow p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="font-semibold">Full Name</div>
                            <div class="mt-1">{{ $user->name }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Father's Name</div>
                            <div class="mt-1">{{ $user->father_name ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Mother's Name</div>
                            <div class="mt-1">{{ $user->mother_name ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Date of Birth</div>
                            <div class="mt-1">{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('M d, Y') : 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Age</div>
                            <div class="mt-1">{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->age : 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Phone</div>
                            <div class="mt-1">{{ $user->phone ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Email</div>
                            <div class="mt-1">{{ $user->email }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Gender</div>
                            <div class="mt-1">{{ ucfirst($user->gender ?? 'N/A') }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Nationality</div>
                            <div class="mt-1">{{ $user->nationality ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Category</div>
                            <div class="mt-1">{{ $user->category ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                <div class="mb-6 mt-10">
                    <h2 class="text-2xl font-bold text-black mb-4">Educational Details</h2>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-16 gap-y-2">
                            <div>Course Fee: <span class="font-medium text-black">₹{{ number_format($user->course_fee ?? 0, 2) }}</span></div>
                            <div>Batch: <span class="font-bold text-black">{{ $user->batch ? $user->batch->name : 'N/A' }}</span></div>
                        </div>
                    </div>
                </div>
                @if($user->attachments && count($user->attachments) > 0)
                <div class="mb-6 mt-10">
                    <h2 class="text-2xl font-bold text-black mb-4">Uploaded Certificates</h2>
                    <div class="bg-white rounded-lg shadow p-6">
                        <ul class="ml-4 list-disc">
                            @foreach($user->attachments as $attachment)
                                <li>
                                    <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ basename($attachment) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                <div class="mb-6 mt-10">
                    <h2 class="text-2xl font-bold text-black mb-4">Progress Report</h2>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm mb-1 text-black"><span>German Language</span><span>78%</span></div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 78%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1 text-black"><span>Grammar</span><span>65%</span></div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1 text-black"><span>Vocabulary</span><span>89%</span></div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 89%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1 text-black"><span>Speaking</span><span>94%</span></div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 94%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/student-dashboard.css') }}">
    @endpush
    @section('styles')
        @stack('styles')
    @endsection
</x-filament-panels::page> 