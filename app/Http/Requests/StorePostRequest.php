<?php

namespace App\Http\Requests;

use App\Rules\MaxPostsPerUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|min:3|unique:posts,title",
            "description" => "required|min:10",
            "image" => "image|mimes:jpeg,jpg,png|max:2048"
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "The title field is required.",
            "title.unique" => "The title must be unique.",
            "description.required" => "The description field is required.",
            "description.string" => "The description must be a string.",
            "description.min" => "The description must be at least 10 characters.",
        ];
    }
}
