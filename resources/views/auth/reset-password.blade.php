@extends('layouts.auth')
@section('title', 'Сброс пароля')
@section('content')
    <x-forms.auth-forms title="Сброс пароля" action="{{ route('password.update') }}" method="post">
        @csrf
        "@dump($errors)
        <input type="hidden" name="token" value="{{ $token }}">
        {{--email--}}
            <x-forms.text-input
                name="email"
                type="email"
                placeholder="Email"
                value="{{ request('email') }}"
                :isError="$errors->has('email')"
            />
            @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
            @enderror
        {{--end email--}}
        {{--password--}}
            <x-forms.text-input
                name="password"
                type="password"
                placeholder="Password"
                :isError="$errors->has('password')"
            />
            @error('password')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
            @enderror
        {{--end password--}}

        {{--confirm password--}}
            <x-forms.text-input
                name="password_confirmation"
                type="password"
                placeholder="password_confirmation"
                :isError="$errors->has('password_confirmation')"
            />
            @error('password_confirmation')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
            @enderror
        {{--end confirm password--}}

        {{--forms.primary-button--}}
        <x-forms.primary-button>Обновить</x-forms.primary-button>
        {{--end forms.primary-button--}}

        {{-- end {{ $buttons }} auth-forms.blade.php  --}}
        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs">
                    <a href="{{ route('login') }}" class="text-white hover:text-white/70 font-bold">Войти</a>
                </div>
            </div>
        </x-slot:buttons>
        {{-- end {{ $buttons }} auth-forms.blade.php  --}}
    </x-forms.auth-forms>

@endsection
