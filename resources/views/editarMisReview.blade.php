@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Editar Reseña</h1>
                <form method="POST" action="{{ route('reviews.update', $review->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="album_id" class="form-label">Álbum</label>
                        <select class="form-control" id="album_id" name="album_id" disabled>
                            <option value="{{ $review->album_id }}">{{ $review->album->name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="review" class="form-label">Reseña</label>
                        <textarea class="form-control" id="review" name="review" required>{{ $review->review }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="rating" class="form-label">Calificación (0-10)</label>
                        <input type="number" class="form-control" id="rating" name="rating" min="0" max="10" value="{{ $review->rating }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Reseña</button>
                </form>
            </div>
        </div>
    </div>
@endsection