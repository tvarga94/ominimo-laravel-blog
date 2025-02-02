<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            Create New Post
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded-md mb-4 text-center">
                <strong>Whoops!</strong> Something went wrong.<br><br>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block font-medium text-gray-700 dark:text-white">Title:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                       class="w-full p-3 border rounded-md focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            <div>
                <label for="content" class="block font-medium text-gray-700 dark:text-white">Content:</label>
                <textarea id="content" name="content" rows="5" required
                          class="w-full p-3 border rounded-md focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white dark:border-gray-600">{{ old('content') }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('posts.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                    Publish Post
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
