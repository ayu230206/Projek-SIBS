<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-2xl p-10 max-w-md w-full">
        <h1 class="text-2xl font-bold text-green-900 mb-6 text-center">Login Akun</h1>

        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-green-800 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('email') border-red-500 @enderror">
                @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-green-800 font-semibold mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('password') border-red-500 @enderror">
                @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" 
                        class="h-4 w-4 text-green-800 focus:ring-green-700 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-green-900">
                        Ingat Saya
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="text-sm text-green-700 hover:underline hover:text-green-900" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full bg-green-800 text-white py-2 rounded-lg font-semibold hover:bg-green-900 transition-colors">
                Login
            </button>
        </form>

        <p class="mt-4 text-center text-green-700">
            Belum punya akun? <a href="{{ route('register') }}" class="text-green-900 font-semibold hover:underline">Daftar</a>
        </p>
    </div>
</body>

</html>