<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - EventHub</title>
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
                <p class="mt-2 text-neutral-muted">Masukkan email untuk reset password</p>
            </div>

            <div class="bg-white border border-neutral-border rounded-2xl p-8 shadow-sm">
                @if (session('status'))
                    <div class="mb-5 rounded-lg bg-success-light p-4 text-sm text-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-error-light p-4 text-sm text-error">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/forgot-password" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-text">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                            class="mt-2 w-full rounded-lg border border-neutral-border px-4 py-3 outline-none focus:border-primary focus:ring-1 focus:ring-primary/20"
                            placeholder="your@email.com">
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-primary px-4 py-3 font-medium text-white transition hover:bg-primary-hover">
                        Kirim Link Reset
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-neutral-muted">
                    Sudah ingat password?
                    <a href="/login" class="font-medium text-neutral-text hover:underline">Masuk</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
