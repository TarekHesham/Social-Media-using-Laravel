<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            "creator_id" => [
                'required',
                'exists:creators,id'
            ]
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
            "creator_id.required" => "The creator field is required."
        ];
    }
}
