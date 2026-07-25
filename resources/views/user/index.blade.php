<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($users as $user)
                            <div class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:shadow-md transition-shadow">
                                <!-- User Avatar -->
                                <div class="w-20 h-20 mb-3 rounded-full overflow-hidden border-2 border-indigo-500">
                                    @if ($user->image)
                                        <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
                                             alt="{{ $user->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- User Info -->
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                    {{ $user->name }} {{ $user->surname }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    {{ $user->nick }}
                                </p>

                                <!-- Image Count -->
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $user->images_count }} {{ Str::plural('image', $user->images_count) }}</span>
                                </div>

                                <!-- Profile Link -->
                                <a href="{{ route('users.show', $user) }}"
                                   class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition-colors text-sm">
                                    View Profile
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
