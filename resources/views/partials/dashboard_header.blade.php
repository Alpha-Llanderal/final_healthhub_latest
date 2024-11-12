<!-- HEADER -->
<header class="bg-primary text-white p-3 fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h5 mb-0 fw-bold">HealthHub Connect</h1>
        <div>
            @if(auth()->check())
            <span>Hi, {{ Auth::user()->firstname }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-light" id="logoutButton">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            @endif
        </div>
    </div>
</header>