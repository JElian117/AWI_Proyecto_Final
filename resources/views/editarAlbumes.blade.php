@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="modal-body">
                <form id="actualizarAlbumForm" action="{{ route('albumes.update', $album->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id ="name" name="name" value="{{ $album->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="uri" class="form-label">URI de Spotify</label>
                        <input type="text" class="form-control" id="uri" name="uri" value="{{ $album->uri }}" required>
                    </div>
                    <div class="form-group">
                        <label for="artist_id" class="form-label">Artista</label>
                        <select class="form-select" id="artist_id" name="artist_id" required>
                            @foreach ($artistas as $artista)
                                <option value="{{ $artista->id }}" {{ $artista->id == $album->artist_id ? 'selected' : '' }}>{{ $artista->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="release_year" class="form-label">Año de lanzamiento</label>
                        <input type="number" class="form-control" id="release_year" name="release_year" value="{{ $album->release_year }}" required>
                    </div>
                    <div class="form-group">
                        <label for="cover_art" class="form-label">Portada URL</label>
                        <input type="text" class="form-control" id="cover_art" name="cover_art" value="{{ $album->cover_art }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection