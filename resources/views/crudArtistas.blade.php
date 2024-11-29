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

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarArtistaModal">
        Agregar Artista
    </button>

    <!-- Modal -->
    <div class="modal fade" id="agregarArtistaModal" tabindex="-1" role="dialog" aria-labelledby="agregarArtistaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarArtistaModalLabel">Agregar Artista</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="agregarArtistaForm" action="{{ route('artistas.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="uri" class="form-label">URI de Spotify</label>
                            <input type="text" class="form-control" id="uri" name="uri" required>
                        </div>
                        <div class="form-group">
                            <label for="image_url" class="form-label">Imagen URL</label>
                            <input type="text" class="form-control" id="image_url" name="image_url">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" form="agregarArtistaForm" class="btn btn-primary">Agregar Artista</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de artistas -->
    <div class="row">
      <div class="table-responsive">
        <table class="table table-striped table-sm table-dark text-white">
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>URI</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach ($artistas as $artista)
                    <tr>
                        <td>{{ $artista->id }}</td>
                        <td>{{ $artista->name }}</td>
                        <td>{{ $artista->uri }}</td>
                        <td>
                          <a href="{{route('artistas.edit', $artista->id)}}" class="btn btn-primary">Editar</a>
                          <form action="{{ route('artistas.delete', $artista->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
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