<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Basil Mohsin E. Fulgencio Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fafafa] text-charcoal antialiased min-h-screen flex items-center px-6 py-16">
    <main class="w-full max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <section class="space-y-6">
            <span class="text-accent font-semibold tracking-widest uppercase text-sm block">Admin Access</span>
            <h1 class="text-4xl lg:text-5xl leading-tight">
                Sign in to manage<br>
                your <span class="text-accent italic">portfolio</span>.
            </h1>
            <p class="text-gray-600 leading-relaxed max-w-md">
                Use your administrator account to update profile information, projects, skills, and messages.
            </p>
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="{{ url('/') }}"
                   class="border border-charcoal px-6 py-3 rounded-none hover:bg-charcoal hover:text-white transition-all duration-300 font-medium text-xs uppercase tracking-widest">
                    Back to Public Site
                </a>
            </div>
        </section>

        <section class="bg-white p-10 lg:p-12 shadow-sm border border-gray-100">
            <h2 class="text-2xl mb-2">Admin Login</h2>
            <p class="text-gray-500 mb-8 text-sm">Enter your credentials to continue.</p>

            <form method="POST" action="{{ url('/admin/login') }}" class="space-y-6">
                @csrf

                @if ($errors->any())
                    <div class="border border-red-200 bg-red-50 text-red-700 p-4 text-sm">
                        <p class="font-medium mb-1">Login failed</p>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        placeholder="your@email.com"
                        class="w-full border-0 border-b border-gray-200 focus:ring-0 focus:border-accent py-3 px-0 text-sm bg-transparent"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest mb-2">Password</label>
                    <input
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full border-0 border-b border-gray-200 focus:ring-0 focus:border-accent py-3 px-0 text-sm bg-transparent"
                        required
                    >
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-xs text-gray-500">
                        <input name="remember" type="checkbox" class="rounded border-gray-300 text-charcoal focus:ring-accent">
                        <span>Remember me</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full bg-charcoal text-white py-4 font-bold uppercase tracking-[0.2em] text-xs hover:bg-accent transition-all duration-300"
                >
                    Sign In
                </button>
            </form>
        </section>
    </main>
</body>
</html>

