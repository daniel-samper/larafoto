<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Uploaded Images') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @foreach ($images as $image)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl max-w-md mx-auto">
                        <!-- User info above the image -->
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center">
                            @if ($image->user && $image->user->image)
                                <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}"
                                     alt="{{ $image->user->name }}"
                                     class="w-10 h-10 rounded-full mr-3">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center mr-3">
                                    <span class="text-gray-600 dark:text-gray-300 font-semibold text-sm">
                                        {{ strtoupper(substr($image->user->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $image->user->name ?? 'Unknown User' }}</span>
                        </div>

                        <!-- Image -->
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->description }}" class="w-full h-auto object-cover">

                        <!-- Description -->
                        <div class="p-4">
                            <p class="text-gray-900 dark:text-gray-100">{{ $image->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($images->count() == 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 text-center max-w-md mx-auto">
                    <p class="text-gray-900 dark:text-gray-100">No images uploaded yet.</p>
                </div>
            @endif

            <!-- Pagination links -->
            <div class="mt-6">
                {{ $images->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
