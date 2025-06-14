<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignRequest extends FormRequest
{
    public function authorize(): bool
    {
        // зайти может только
        return auth()->guest();
    }
    public function rules(): array
    {
        return [
            'email' => 'required|email:dns|exists:users,email',
            'password' => 'required|min:5|max:32',
        ];
    }
    public function messages(): array{
        return [
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.email' => 'Введите корректный Email.',
            'email.exists' => 'Пользователь с таким Email не найден.',
            'email.unique' => 'Этот Email уже зарегистрирован.',

            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать не менее 5 символов.',
            'password.max' => 'Пароль не должен превышать 32 символа.',
        ];
    }
}
