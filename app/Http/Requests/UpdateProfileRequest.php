<?php

namespace App\Http\Requests;

use App\Rules\UniqueEmail;
use App\Rules\UniqueUsername;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            "firstName" => ["required", "string", "max:100"],
            "lastName" => ["required", "string", "max:100"],
            "username" => ["required", "string", "max:100", new UniqueUsername($this->user()->id)],
            "email" => ["required", "string", "email", new UniqueEmail($this->user()->id)],
            "bio" => ["nullable", "string", "max:255"],
            "profilePicture" => ["mimes:jpeg,jpg,png", "max:1024"]
        ];
    }
}
