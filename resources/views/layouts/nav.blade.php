<div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
        @Auth
            <div class="p-2 text-muted">Welcome <a
                    href=#><strong><i>{{ \Illuminate\Support\Facades\Auth::user()->email }}</i></strong></a></div>
            <a class="p-2 text-muted" href="/logout">Logout</a>
            <a class="p-2 text-muted" href="/payments">Payments</a>
            <a class="p-2 text-muted" href="/orders">Orders</a>
        @endauth
        @guest
            <a class="p-2 text-muted" href="/register">Register</a>
            <a class="p-2 text-muted" href="/login">Login</a>
        @endguest

        <a class="p-2 text-muted" href="/">Home</a>
    </nav>
</div>
<hr>

