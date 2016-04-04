<nav class="navbar navbar-default" role="navigation">
    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Abrir navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">Socialdaw</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div id="navbar" class="collapse navbar-collapse">

            @if (Auth::check())
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('home') }}">Muro</a></li>
                    <li><a href="{{ route('friends.index') }}">Amigos</a></li>
                </ul>

                <form class="navbar-form navbar-left" role="search" action="{{ route('search.resultados') }}">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="Busca amigos">
                    </div>
                    <button type="submit" class="btn btn-default">Encuentra!</button>
                </form>
            @endif

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cuenta<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('profile.index', ['username' => Auth::user()->username]) }}">
                                    {{ Auth::user()->getNombreCompletoOUsername() }}
                                </a>
                            </li>
                            <li><a href="{{ route('profile.edit') }}">Actualizar perfil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('auth.logout') }}">Salir</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('auth.registro') }}">Regístrate</a></li>
                    <li><a href="{{ route('auth.login') }}">Entrar</a></li>
                @endif
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>