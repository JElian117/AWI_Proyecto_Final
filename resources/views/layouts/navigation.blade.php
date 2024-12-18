<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            {{ __('Dashboard') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @if(Auth::user()->rol == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('search') }}" class="btn btn-outline-light text-black">Busca en Spotify</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-light me-2 text-black">Ir a Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('artistas.index') }}" class="btn btn-outline-light me-2 text-black">Ir a Artistas</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('albumes.index') }}" class="btn btn-outline-light text-black">Ir a Álbumes</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reviews.index') }}" class="btn btn-outline-light text-black">Hacer Reseña</a>
                    </li>
                @endif

                @if(Auth::user()->rol == 'reseñador')
                    <li class="nav-item">
                        <a href="{{ route('reviews.index') }}" class="btn btn-outline-light text-black">Hacer Reseña</a>
                    </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            {{ __('Profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Log Out') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>