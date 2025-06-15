<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // страничка
    public function login(Request $request)
    {
        return view('auth.login');
    }

    // обработка логина в реквесте
    public function signin(SignRequest $request): RedirectResponse
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Неверный email или пароль.',
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    // страничка
    public function register(Request $request)
    {
        return view('auth.register');
    }

    // обработка регистрации
    public function registeruser(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        event(new Registered($user));
        auth()->login($user);

        $request->session()->regenerate();
        // лог в телегу
        logger()->channel('telegram')->info(
            "\n🆕 Новый пользователь зарегистрирован:\n" .
            "👤 Имя: {$request['name']}\n" .
            "📧 Email: {$request['email']}\n" .
            "📅 Время: " . now()->format('Y-m-d H:i:s') . "\n" .
            "🌐 IP: " . request()->ip() . "\n" .
            "📍 URL: " . url()->current()
        );

        return redirect()->intended('/');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    //страничка пароля
    public function forgot(Request $request)
    {
        return view('auth.forgot-password');
    }

    // обработка пароля
    public function forgotPassword(ForgotRequest $request): RedirectResponse
    {
        $request->validated();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? back()->with(['message' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset(string $token)
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('message', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function github(Request $request): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(): RedirectResponse {
        $githubUser = Socialite::driver('github')->user();

        $user = User::query()->updateOrCreate(
            ['github_id' => $githubUser->id],
            [
                'name' => $githubUser->name ?? $githubUser->nickname,
                'email' => $githubUser->email,
                'password' => bcrypt(Str::random(16)), // фиктивный пароль
            ]
        );

        auth()->login($user);

        return redirect()->intended('/');

    }
}
