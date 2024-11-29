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

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarAlbumModal">
        Agregar Álbum
    </button>

    <!-- Modal -->
    <div class="modal fade" id="agregarAlbumModal" tabindex="-1" role="dialog" aria-labelledby="agregarAlbumModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarAlbumModalLabel">Agregar Álbum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="agregarAlbumForm" action="{{ route('albumes.create') }}" method="POST">
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
                            <label for="artist_id" class="form-label">Artista</label>
                            <select class="form-select" id="artist_id" name="artist_id" required>
                                @foreach ($artistas as $artista)
                                    <option value="{{ $artista->id }}">{{ $artista->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="release_year" class="form-label">Año de lanzamiento</label>
                            <input type="number" class="form-control" id="release_year" name="release_year" required>
                        </div>
                        <div class="form-group">
                            <label for="cover_art" class="form-label">Portada URL</label>
                            <input type="text" class="form-control" id="cover_art" name="cover_art">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" form="agregarAlbumForm" class="btn btn-primary">Agregar Álbum</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de álbumes -->
    <div class="row">
      <div class="table-responsive">
        <table class="table table-striped table-sm table-dark text-white">
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>URI</th>
                <th>Artista</th>
                <th>Año</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach ($albumes as $album)
                    <tr>
                        <td>{{ $album->id }}</td>
                        <td>{{ $album->name }}</td>
                        <td>{{ $album->uri }}</td>
                        <td>{{ $album->artista->name }}</td> 
                        <td>{{ $album->release_year }}</td>
                        <td>
                          <a href="{{route('albumes.edit', $album->id)}}" class="btn btn-primary">Editar</a>
                          <form action="{{ route('albumes.delete', $album->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class ="btn btn-danger">Eliminar</button>
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