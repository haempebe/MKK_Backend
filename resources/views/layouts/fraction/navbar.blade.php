<nav class="bg-dark navbar-dark navbar navbar-expand-md">
    <div class="container px-md-0 px-3">
        <a href="/" class="d-inline-flex link-success text-decoration-none text-white fw-bolder fs-5">
            <span style="height: 20px;width: 20px;" class="bg-success me-1 rounded my-auto"></span> Portal Drakor
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars"
            aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbars">
            <ul class="navbar-nav mx-auto ms-lg-5 mb-2 mb-lg-0">
                <li class="nav-item"><a href="{{ url('/') }}"
                        class="nav-link px-2 {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">Home</a>
                </li>
                @guest
                @else
                    <li class="nav-item"><a href="{{ route('dashboard') }}"
                            class="nav-link px-2 {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">Dashboard</a>
                    </li>
                    <li class="nav-item"><a href="{{ route('films') }}"
                            class="nav-link px-2 {{ Route::currentRouteName() == 'films' ? 'active' : '' }}">Film</a></li>
                    <li class="nav-item"><a href="{{ route('genres') }}"
                            class="nav-link px-2 {{ Route::currentRouteName() == 'genres' ? 'active' : '' }}">Genre</a></li>
                @endguest
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-light me-2">{{ __('Login') }}</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-light">{{ __('Register') }}</a>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                @endguest
            </ul>
        </div>
    </div>

</nav>
