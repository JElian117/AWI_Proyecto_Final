@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="modal-body">
                <form id="actualizarArtistaForm" action="{{ route('artistas.update', $artista->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $artista->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="uri" class="form-label">URI de Spotify</label>
                        <input type="text" class="form-control" id="uri" name="uri" value="{{ $artista->uri }}" required>
                    </div>
                    <div class="form-group">
                        <label for="image_url" class="form-label">Imagen URL</label>
                        <input type="text" class="form-control" id="image_url" name="image_url" value="{{ $artista->image_url }}">
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