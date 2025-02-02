<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            Update Post
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-900 shadow-md rounded-lg mt-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded-md mb-4">
                <strong>Whoops!</strong> Something went wrong.<br><br>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title:</label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content:</label>
                <textarea id="content" name="content" rows="5" required
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">{{ old('content', $post->content) }}
                </textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
