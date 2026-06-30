<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — School MS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
    <div class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-indigo-950 via-indigo-900 to-violet-900 p-12 flex-col justify-between overflow-hidden">
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-violet-500 rounded-full blur-3xl"></div>
            </div>
            <div class="relative">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center text-2xl ring-1 ring-white/20">🏫</div>
                    <div>
                        <h1 class="text-xl font-bold text-white">School MS</h1>
                        <p class="text-indigo-300/80 text-sm">Management System</p>
                    </div>
                </div>
            </div>
            <div class="relative space-y-6">
                <h2 class="text-4xl font-bold text-white leading-tight">Manage your school<br><span class="text-indigo-300">with confidence.</span></h2>
                <p class="text-indigo-200/80 text-lg max-w-md">Students, teachers, attendance, fees &amp; exams — all in one place.</p>
                <div class="flex gap-4">
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-5 py-4 ring-1 ring-white/10">
                        <div class="text-2xl font-bold text-white">100%</div>
                        <div class="text-xs text-indigo-300">Cloud Ready</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-5 py-4 ring-1 ring-white/10">
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-xs text-indigo-300">Access</div>
                    </div>
                </div>
            </div>
            <p class="relative text-indigo-400/60 text-sm">© {{ date('Y') }} School Management System</p>
        </div>

        <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-slate-50">
            <div class="w-full max-w-md">
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-lg text-white">🏫</div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900">School MS</h1>
                        <p class="text-slate-500 text-xs">Sign in to continue</p>
                    </div>
                </div>

                <div class="card card-body shadow-lg shadow-slate-200/50">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-slate-900">Welcome back</h2>
                        <p class="text-slate-500 text-sm mt-1">Enter your credentials to access the dashboard</p>
                    </div>

                    @if($errors->any())
                        <div class="alert-error mb-6">
                            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label class="label">Email address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="input" placeholder="you@school.com">
                        </div>
                        <div>
                            <label class="label">Password</label>
                            <input type="password" name="password" required class="input" placeholder="••••••••">
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remember" id="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="remember" class="text-sm text-slate-600">Remember me</label>
                        </div>
                        <button type="submit" class="btn-primary w-full py-3 text-base">
                            Sign In
                        </button>
                    </form>

                    <div class="mt-6 p-3 rounded-xl bg-slate-50 border border-slate-100 text-center">
                        <p class="text-xs text-slate-500">Demo credentials</p>
                        <p class="text-sm font-mono text-slate-700 mt-1">admin@school.com / password</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
