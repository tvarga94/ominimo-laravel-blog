@if ($posts->isEmpty())
    <p class="text-gray-500 text-center">No blog posts available.</p>
@else
    <ul class="space-y-4">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-md text-center">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-md text-center">
                {{ session('error') }}
            </div>
        @endif

        @foreach ($posts as $post)
            <li class="p-4 bg-white rounded-lg shadow flex justify-between items-center">
                <div>
                    <a href="{{ route('posts.show', $post->id) }}" class="text-lg font-semibold text-blue-500 hover:underline">
                        {{ $post->title }}
                    </a>
                    <p class="text-gray-600">{{ Str::limit($post->content, 100) }}</p>
                    <p class="text-sm text-gray-500">By: {{ $post->user->name ?? 'Unknown' }} | {{ $post->created_at->format('F j, Y') }}</p>
                </div>

                @auth
                    <div class="flex space-x-2">
                        <a href="{{ route('posts.edit', $post->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                🗑️ Delete
                            </button>
                        </form>
                    </div>
                @endauth
            </li>
        @endforeach
    </ul>

    <div class="mt-6 text-center">
        {{ $posts->links() }}
    </div>
@endif
