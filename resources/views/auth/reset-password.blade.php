<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - EventHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-neutral-bg font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <a href="/" class="text-3xl font-bold text-neutral-text font-poppins">EventHub</a>
                <p class="mt-2 text-neutral-muted">Buat password baru</p>
            </div>

            <div class="bg-white border border-neutral-border rounded-2xl p-8 shadow-sm">
                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-error-light p-4 text-sm text-error">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $resetEmail = old('email', request()->query('email', ''));
                @endphp

                <form method="POST" action="{{ url('/reset-password') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <input type="hidden" name="email" value="{{ $resetEmail }}">

                    <div>
                        <label for="password" class="block text-sm font-medium text-neutral-text">Password Baru</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="mt-2 w-full rounded-lg border border-neutral-border px-4 py-3 outline-none focus:border-primary focus:ring-1 focus:ring-primary/20"
                            placeholder="Minimal 8 karakter">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-neutral-text">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="mt-2 w-full rounded-lg border border-neutral-border px-4 py-3 outline-none focus:border-primary focus:ring-1 focus:ring-primary/20"
                            placeholder="Ulangi password baru">
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-primary px-4 py-3 font-medium text-white transition hover:bg-primary-hover">
                        Reset Password
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-neutral-muted">
                    <a href="{{ url('/login') }}" class="font-medium text-neutral-text hover:underline">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
