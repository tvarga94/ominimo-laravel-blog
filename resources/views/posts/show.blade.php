<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            Viewing Post
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg">
        {{-- Post Content --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                {{ $post->title }}
            </h1>
            <p class="text-gray-600 text-lg leading-relaxed">
                {{ $post->comment }}
            </p>
            <p class="text-sm text-gray-500 mt-4">
                By: <span class="font-semibold">{{ $post->user->name ?? 'Unknown' }}</span>
                | {{ $post->created_at->format('F j, Y') }}
            </p>
        </div>

        {{-- Back & Edit/Delete Buttons --}}
        <div class="flex justify-end space-x-2">
            <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                Back to Posts
            </a>

            @auth
                @if(auth()->id() === $post->user_id)
                    <a href="{{ route('posts.edit', $post->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                        Edit
                    </a>

                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                            Delete
                        </button>
                    </form>
                @endif
            @endauth
        </div>

        {{-- Comments Section --}}
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Comments</h2>

            {{-- Check if there are comments --}}
            @if ($post->comments->isEmpty())
                <p class="text-gray-500 mt-2">No comments yet. Be the first to comment!</p>
            @else
                @foreach ($post->comments as $comment)
                    <div class="p-4 bg-gray-100 rounded-md mt-4">
                        <p class="text-gray-700">{{ $comment->comment }}</p>
                        <p class="text-sm text-gray-500">By: {{ $comment->user->name ?? 'Guest' }} | {{ $comment->created_at->format('F j, Y') }}</p>

                        @auth
                            @if(auth()->id() === $comment->user_id || auth()->id() === $post->user_id)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                        🗑️ Delete
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Add Comment Section --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Leave a Comment</h3>

            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-2">
                @csrf

                <textarea name="comment" required
                          class="w-full p-2 border rounded-md focus:ring focus:ring-blue-300"
                          placeholder="Write your comment here..."></textarea>

                <div class="flex justify-end mt-2">
                    <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                        Post Comment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
