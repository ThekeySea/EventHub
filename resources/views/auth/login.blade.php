<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - EventHub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <a href="/" class="text-3xl font-bold text-gray-900">
                    EventHub
                </a>

                <p class="mt-2 text-gray-600">
                    Sign in to your account
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">

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

                <form method="POST" action="/login" class="space-y-5">

                    @csrf

                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                        >
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                        >
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <input id="remember" type="checkbox" name="remember" value="1" class="rounded border-gray-300">
                            <label for="remember" class="text-sm text-gray-600">Remember me</label>
                        </div>
                        <a href="/forgot-password" class="text-sm font-medium text-gray-900 hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-gray-900 px-4 py-3 font-medium text-white transition hover:bg-gray-800"
                    >
                        Sign In
                    </button>

                </form>

                <div class="mt-6 text-center text-sm text-gray-600">

                    Don't have an account?

                    <a
                        href="/register"
                        class="font-medium text-gray-900 hover:underline"
                    >
                        Create one
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>
</html>