<?php

namespace App\Http\Controllers;

use App\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->postRepository->all());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->postRepository->find($id));
    }

    public function create(): JsonResponse
    {
        return response()->json(['message' => 'Show post creation form.'], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        return response()->json($this->postRepository->create($data), 201);
    }

    public function edit(int $id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['message' => 'Show edit form.', 'post' => $post]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($this->postRepository->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['deleted' => $this->postRepository->delete($id)]);
    }
}
