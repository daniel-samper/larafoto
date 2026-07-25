<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name . ' ' . $user->surname }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- User Profile Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <!-- Avatar -->
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-indigo-500 flex-shrink-0">
                            @if ($user->image)
                                <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
                                     alt="{{ $user->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white font-bold text-3xl">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- User Info -->
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $user->name }} {{ $user->surname }}
                            </h1>
                            <p class="text-lg text-indigo-600 dark:text-indigo-400 font-medium mb-3">
                                {{ $user->nick }}
                            </p>

                            <div class="flex flex-wrap justify-center md:justify-start gap-6 mb-4 text-sm">
                                <div class="text-gray-700 dark:text-gray-300">
                                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $user->images_count }}</span>
                                    Images
                                </div>
                                <div class="text-gray-700 dark:text-gray-300">
                                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">0</span>
                                    Followers
                                </div>
                                <div class="text-gray-700 dark:text-gray-300">
                                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">0</span>
                                    Following
                                </div>
                            </div>

                            <div class="flex justify-center md:justify-start gap-2 mt-4">
                                @if (Auth::id() !== $user->id)
                                <button class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition-colors">
                                    Follow
                                </button>
                                @endif

                                @if (Auth::id() === $user->id)
                                <a href="{{ route('profile.edit') }}"
                                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-semibold rounded-lg shadow transition-colors">
                                    Edit Profile
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Email (only if viewing own profile) -->
                    @if (Auth::id() === $user->id)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Email: {{ $user->email }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- User Images -->
            @if ($user->images_count > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ $user->name }}'s Images ({{ $user->images_count }})
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach ($user->images as $image)
                            <a href="{{ route('images.show', $image) }}" class="block relative group aspect-square overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     alt="{{ $image->description }}"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500 dark:text-gray-400">
                No images yet.
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
