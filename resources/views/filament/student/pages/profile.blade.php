<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::card>
            <div class="space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold">Personal Information</h2>
                        <p class="text-gray-500">Your personal details.</p>
                    </div>
                    @if(auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture" class="h-24 w-24 rounded-full object-cover">
                    @endif
                </div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Full Name</p>
                        <p>{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email Address</p>
                        <p>{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Father's Name</p>
                        <p>{{ auth()->user()->father_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Mother's Name</p>
                        <p>{{ auth()->user()->mother_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                        <p>{{ auth()->user()->dob ? auth()->user()->dob->format('F j, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Gender</p>
                        <p>{{ ucfirst(auth()->user()->gender) }}</p>
                    </div>
                </div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="space-y-4">
                <div>
                    <h2 class="text-xl font-bold">Course Details</h2>
                    <p class="text-gray-500">Your enrolled course information.</p>
                </div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Batch</p>
                        <p>{{ auth()->user()->batch ? auth()->user()->batch->name : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Course Fee</p>
                        <p>₹{{ number_format(auth()->user()->course_fee, 2) }}</p>
                    </div>
                </div>
            </div>
        </x-filament::card>

        @if(auth()->user()->attachments && count(auth()->user()->attachments) > 0)
            <x-filament::card>
                <div class="space-y-4">
                    <div>
                        <h2 class="text-xl font-bold">Uploaded Documents</h2>
                        <p class="text-gray-500">Your uploaded documents and attachments.</p>
                    </div>
                    <ul class="space-y-2">
                        @foreach(auth()->user()->attachments as $attachment)
                            <li>
                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="text-primary-600 hover:underline">
                                    {{ basename($attachment) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </x-filament::card>
        @endif
    </div>
</x-filament-panels::page> 