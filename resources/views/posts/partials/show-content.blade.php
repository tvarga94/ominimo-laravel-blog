<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
        {{ $post->title }}
    </h1>
    <p class="text-gray-600 text-lg leading-relaxed">
        {{ $post->content }}
    </p>
    <p class="text-sm text-gray-500 mt-4">
        By: <span class="font-semibold">{{ $post->user->name ?? 'Unknown' }}</span>
        | {{ $post->created_at->format('F j, Y') }}
    </p>
</div>

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
