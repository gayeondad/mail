<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return true;    // 임시로 허용
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:20',
            'content' => 'required'
        ];
        // PostsController 에서 사용한 validation 대체
        // $this->validate($request, [
        //     'title' => 'required|max:20',
        //     'content' => 'required'
        // ]);
    }
}
