<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //
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
            "title" => "required",
            "description" => "required|min:10",
            "image" => "image|mimes:jpeg,jpg,png|max:2048"
        ];
    }

    function messages()
    {
        return [
            "title.required" => "No student without name",
            "description.required" => "No student without email",
            "image.mimes" => "File type not allowed !!"
        ];
    }
}
