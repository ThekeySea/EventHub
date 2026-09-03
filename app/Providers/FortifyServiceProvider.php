<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\Laravel\Fortify\Contracts\ResetsUserPasswords::class, ResetUserPassword::class);
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = $request->user();

                    return match ($user->role) {
                        'admin' => redirect('/admin/dashboard'),
                        'organizer' => redirect('/organizer/dashboard'),
                        'member' => redirect('/member/dashboard'),
                        default => redirect('/'),
                    };
                }
            };
        });

        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    $user = $request->user();

                    return match ($user->role) {
                        'admin' => redirect('/admin/dashboard'),
                        'organizer' => redirect('/organizer/dashboard'),
                        'member' => redirect('/member/dashboard'),
                        default => redirect('/'),
                    };
                }
            };
        });
    }

    public function boot(): void
    {
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::createUsersUsing(CreateNewUser::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            $throttleKey = Str::transliterate(Str::lower($email).'|'.$request->ip());
            
            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}