<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\PostRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    use AuthorizesRequests;

    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(): View
    {
        $posts = $this->postRepository->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function show(int $id): View
    {
        $post = $this->postRepository->find($id);

        return view('posts.show', compact('post'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->postRepository->create($request->validated());
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(int $id): mixed
    {
        $post = $this->postRepository->find($id);

        try {
            $this->authorize('update', $post);
        } catch (AuthorizationException $e) {
            return redirect()->route('posts.index')->with('error', 'You are not authorized to edit this post.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, int $id): RedirectResponse
    {
        $post = $this->postRepository->find($id);

        try {
            $this->authorize('update', $post);
        } catch (AuthorizationException $e) {
            return redirect()->route('posts.index')->with('error', 'You are not authorized to update this post.');
        }

        $this->postRepository->update($id, $request->validated());

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }

        try {
            $this->authorize('delete', $post);
        } catch (AuthorizationException $e) {
            return redirect()->route('posts.index')->with('error', 'You are not authorized to delete this post.');
        }

        $this->postRepository->delete($id);

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
