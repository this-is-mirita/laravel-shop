@extends('layouts.auth')
@section('title', 'Забыли пароль')
@section('content')
    <x-forms.auth-forms title="Забыли пароль" action="">
        @csrf
        {{--email--}}
            <x-forms.text-input
                name="email"
                type="email"
                placeholder="Email"
                :isError="$errors->has('email')"
                required
            />
            @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
            @enderror
        {{--end email--}}

        {{--forms.primary-button--}}
        <x-forms.primary-button>Отправить</x-forms.primary-button>
        {{--end forms.primary-button--}}

        {{-- {{ $socialAuth }} auth-forms.blade.php  --}}
        {{--<x-slot:socialAuth></x-slot:socialAuth>--}}
        {{-- end {{ $socialAuth }} auth-forms.blade.php  --}}


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
