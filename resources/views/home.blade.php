@extends('layouts.auth')
@section('content')
    @dump(auth()->user())
    @auth
        <form action="{{ route('logout') }}" method="post">
            @method('DELETE')
            @csrf
            <button class="btn-primary" type="submit">Выход</button>
        </form>
    @endauth
    @guest
        <a href="{{route('login')}}">login</a>
        <a href="{{route('register')}}">register</a>
    @endguest
@endsection
