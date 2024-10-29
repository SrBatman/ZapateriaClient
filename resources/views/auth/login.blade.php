@extends ('layouts.header')

@section('content')

<div class="relative overflow-x-auto">
    @if(session('message'))
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif
    <!-- Make a login view -->
<div class="mb-48 h-32"> </div>   
<div class="max-w-md mx-auto bg-white p-8 border border-gray-300">
    <h2 class="text-2xl font-bold mb-6 text-center">Inicio sesion</h2>
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded mt-1" required autofocus>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Contraseña</label>
            <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-gray-700">Remember Me</label>
        </div>
        <div class="mb-4">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
        </div>
      
{{--      
        @if (Route::has('password.request'))
            <div class="text-center">
                <a class="text-blue-500" href="{{ route('password.request') }}">Forgot Your Password?</a>
            </div>
        @endif --}}
    </form>
 
</div>
   
</div>

@endsection