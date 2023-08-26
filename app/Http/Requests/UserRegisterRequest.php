<?php

namespace App\Http\Requests;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\FormatResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:50', Rule::unique('users')],
            'password' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:50'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        FormatResource::error(400, $validator->getMessageBag());
    }
}
