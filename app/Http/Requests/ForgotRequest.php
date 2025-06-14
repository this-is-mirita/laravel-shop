<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:dns'
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Пожалуйста, введите email.',
            'email.email' => 'Введите корректный email.',
            'email.dns' => 'Email должен быть с реальным доменом.',
            'email.exists' => 'Пользователь с таким email не найден.',
        ];
    }
}
