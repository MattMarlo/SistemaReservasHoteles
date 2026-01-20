<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white font-bold text-xl">
            Reservas Hoteles
        </div>
        <div class="flex items-center space-x-4">
            @if(Auth::check())
                <span class="text-white">Bienvenido, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:text-gray-200">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-gray-200">Login</a>
                <a href="{{ route('register') }}" class="text-white hover:text-gray-200">Register</a>
            @endif
        </div>
    </div>
</nav>
