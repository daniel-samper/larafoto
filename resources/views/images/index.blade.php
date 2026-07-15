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
                        <a href="{{ route('images.show', ['image' => $image]) }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->description }}" class="w-full h-auto object-cover cursor-pointer">
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
                            <!-- Comment Button (Toggle) -->
                            <div class="flex items-center mb-3 cursor-pointer comments-toggle" data-image-id="{{ $image->id }}">
                                <img src="{{ asset('img/heart-black.png') }}" alt="Heart" class="w-6 h-6 mr-2 comments-icon-{{ $image->id }}">
                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                    Comentarios ({{ $image->comments_count ?? $image->comments->count() }})
                                </span>
                            </div>

                            <!-- Comment Form -->
                            @auth
                            <form id="comment-form-{{ $image->id }}" action="{{ route('comments.store') }}" method="POST" class="hidden mb-4 comment-form">
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
                            <div id="comments-list-{{ $image->id }}" class="hidden comments-list">
                                @foreach ($image->comments as $comment)
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 mb-2">
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
                                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Toggle Script for this image -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const toggle = document.querySelector('.comments-toggle[data-image-id="{{ $image->id }}"]');
                                if (toggle) {
                                    toggle.addEventListener('click', function() {
                                        const commentForm = document.getElementById('comment-form-{{ $image->id }}');
                                        const commentsList = document.getElementById('comments-list-{{ $image->id }}');

                                        if (commentForm && commentsList) {
                                            commentForm.classList.toggle('hidden');
                                            commentsList.classList.toggle('hidden');
                                        }
                                    });
                                }
                            });
                        </script>
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
