@extends('layouts.app')

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">


  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>

@section('content')
<body class="bg-dark bg-gradient">

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarUsuarioModal">
        Agregar usuario
    </button>

    <!-- Modal -->
    <div class="modal fade" id="agregarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="agregarUsuarioForm" action="{{ route('usuarios.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellidoP" class="form-label">Apellido paterno</label>
                            <input type="text" class="form-control" id="apellidoP" name="apellidoP">
                        </div>
                        <div class="form-group">
                            <label for="apellidoM" class="form-label">Apellido materno</label>
                            <input type="text" class="form-control" id="apellidoM" name="apellidoM">
                        </div>
                        <div class="form-group">
                            <label for="clave" class="form-label">Clave única</label>
                            <input type="text" class="form-control" id="clave" name="clave">
                        </div>
                        <div class="form-group">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-select" id="rol" name="rol">
                                <option value="reseñador">Reseñador</option>
                                <option value="moderador">Moderador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="clave" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="psw" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="psw" name="psw" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" form="agregarUsuarioForm" class="btn btn-primary">Agregar usuario</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="row">
      <div class="table-responsive">
        <table class="table table-striped table-sm table-dark text-white">
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Email</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name.' '.$usuario->apellidoP.' '.$usuario->apellidoM }}</td>
                        <td>{{ $usuario->rol }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                          <a href="{{route('usuarios.edit', $usuario->id)}}" class="btn btn-primary">Editar</a>
                          <form action="{{ route('usuarios.delete', $usuario->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            <input type="hidden" name="id" value="{{$usuario->id}}">
                          </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>

  </main>
</body>

@endsection