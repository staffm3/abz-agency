@props([
    "pages" => [
        "home" => "home",
        "users" => "users",
        "positions" => "positions",
        "create user" => "user.create"
    ]
])
<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('img/icon.svg') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @foreach ($pages as $page => $route)
                    <li class="nav-item">
                        <a class="nav-link
                        @if (url()->current() == route($route)) active @endif
                        "
                        href="{{ route($route) }}">
                            {{ ucfirst($page) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
