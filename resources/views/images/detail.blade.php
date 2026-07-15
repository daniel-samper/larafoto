<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Image Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl max-w-4xl mx-auto">
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
                <a href="{{ route('images.show', $image->id) }}">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->description }}" class="w-full h-auto object-contain max-h-[70vh] cursor-pointer hover:opacity-90 transition-opacity">
                </a>

                <!-- Description -->
                <div class="p-4">
                    <p class="text-gray-900 dark:text-gray-100">{{ $image->description }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ format_time_diff($image->created_at) }}
                    </p>
                </div>

                <!-- Comments Section -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <div id="comments-toggle" class="flex items-center mb-3 cursor-pointer">
                        <img src="{{ asset('img/heart-black.png') }}" alt="Heart" class="w-6 h-6 mr-2">
                        <span class="font-medium text-gray-900 dark:text-gray-100">
                            Comentarios ({{ $image->comments_count ?? $image->comments->count() }})
                        </span>
                    </div>

                    <!-- Comment Form -->
                    @auth
                    <form id="comment-form" action="{{ route('comments.store') }}" method="POST" class="hidden mb-4">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                        <div class="flex mb-2">
                            <textarea name="comment"
                                      class="flex-1 border border-gray-300 dark:border-gray-600 rounded-l-lg p-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                      placeholder="Write a comment..."
                                      rows="3"
                                      required>{{ old('comment') }}</textarea>
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg font-medium transition duration-200">
                                Send
                            </button>
                        </div>
                        @error('comment')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </form>
                    @endauth

                    <!-- Comments List -->
                    <div id="comments-list" class="hidden mt-4 space-y-3">
                        @foreach ($image->comments as $comment)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 relative hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-1">
                                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $comment->user->name ?? 'Unknown User' }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                                @if(function_exists('format_time_diff'))
                                                    {{ format_time_diff($comment->created_at) }}
                                                @else
                                                    {{ $comment->created_at->diffForHumans() }}
                                                @endif
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $comment->comment }}</p>
                                    </div>

                                    <!-- Delete Button -->
                                    @if (Auth::id() === $comment->user_id || Auth::id() === $image->user_id)
                                        <form action="{{ route('comments.delete', $comment->id) }}" method="POST" class="ml-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20"
                                                    title="Delete comment"
                                                    onclick="return confirm('Are you sure you want to delete this comment?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Toggle Script -->
                    <script>
                        document.getElementById('comments-toggle').addEventListener('click', function() {
                            const commentForm = document.getElementById('comment-form');
                            const commentsList = document.getElementById('comments-list');

                            if (commentForm.classList.contains('hidden')) {
                                commentForm.classList.remove('hidden');
                                commentsList.classList.remove('hidden');
                            } else {
                                commentForm.classList.add('hidden');
                                commentsList.classList.add('hidden');
                            }
                        });
                    </script>
                </div>
            </div>

            <!-- Back to images list -->
            <div class="mt-6 text-center">
                <a href="{{ route('images.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Images
                </a>
            </div>
        </div>
    </div>
</x-app-layout>