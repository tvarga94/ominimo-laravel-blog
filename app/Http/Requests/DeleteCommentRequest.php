<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $comment = $this->route('comment');

        return auth()->id() === $comment->user_id || auth()->id() === $comment->post->user_id;
    }

    public function rules(): array
    {
        return [];
    }
}
