<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|string|min:5|max:32|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно.',
            'name.string' => 'Имя должно быть строкой.',
            'name.min' => 'Имя должно содержать минимум :min символа.',
            'name.max' => 'Имя не должно превышать :max символов.',

            'email.required' => 'Поле "Email" обязательно.',
            'email.email' => 'Введите корректный Email.',
            'email.dns' => 'Домен указанного Email не существует.',
            'email.unique' => 'Этот Email уже зарегистрирован.',

            'password.required' => 'Поле "Пароль" обязательно.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать не менее :min символов.',
            'password.max' => 'Пароль не должен превышать :max символов.',
            'password.confirmed' => 'Пароль и подтверждение не совпадают.',
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'email' => str(request('email'))->squish()->lower()->value()
        ]);
    }
}
