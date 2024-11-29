@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="modal-body">
                <form id="actualizarUsuarioForm" action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->name }}">
                    </div>
                    <div class="form-group">
                        <label for="apellidoP" class="form-label">Apellido paterno</label>
                        <input type="text" class="form-control" id="apellidoP" name="apellidoP" value="{{ $usuario->apellidoP }}">
                    </div>
                    <div class="form-group">
                        <label for="apellidoM" class="form-label">Apellido materno</label>
                        <input type="text" class="form-control" id="apellidoM" name="apellidoM" value="{{ $usuario->apellidoM }}">
                    </div>
                    <div class="form-group">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol">
                            <option value="reseñador" {{ $usuario->rol == 'reseñador' ? 'selected' : '' }}>Reseñador</option>
                            <option value="moderador" {{ $usuario->rol == 'moderador' ? 'selected' : '' }}>Moderador</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}">
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