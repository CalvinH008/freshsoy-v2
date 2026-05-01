<nav class="flex items-center justify-between">
    <span></span>

    <div class="flex items-center gap-4">
        @auth
            <p> {{ auth()->user()->name }} </p>
            <p> {{ auth()->user()->getRoleNames()->first() }} </p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" name="logout">logout</button>
            </form>
        @endauth
        @guest
            <a href=" {{ route('login') }} ">Login</a>
        @endguest
    </div>
</nav>
