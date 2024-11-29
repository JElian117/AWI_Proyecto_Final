<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artista;

class albumesController extends Controller
{
    public function index() {
        $albumes = Album::with('artista')->get();
        $artistas = Artista::all();
        return view('crudAlbumes', compact('albumes', 'artistas'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'uri' => 'required|string',
            'artist_id' => 'required|exists:artistas,id',
            'release_year' => 'required|integer',
            'cover_art' => 'nullable|string',
        ]);

        $nuevoAlbum = new Album();
        $nuevoAlbum->name = $request->name;
        $nuevoAlbum->uri = $request->uri;
        $nuevoAlbum->artist_id = $request->artist_id;
        $nuevoAlbum->release_year = $request->release_year;
        $nuevoAlbum->cover_art = $request->cover_art;
        $nuevoAlbum->save();

        return redirect()->back()->with('success', 'Álbum creado exitosamente.');
    }

    public function edit($id){
        $album = Album::find($id);
        $artistas = Artista::all();
        return view('editarAlbum', compact('album', 'artistas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'uri' => 'required|string',
            'artist_id' => 'required|exists:artistas,id',
            'release_year' => 'required|integer',
            'cover_art' => 'nullable|string',
        ]);

        $album = Album::find($id);
        $album->name = $request->name;
        $album->uri = $request->uri;
        $album->artist_id = $request->artist_id;
        $album->release_year = $request->release_year;
        $album->cover_art = $request->cover_art;
        $album->save();

        return redirect()->route('albumes.index')->with('success', 'Álbum actualizado exitosamente.');
    }
    
    public function delete($id){
        $album = Album::find($id);
        $album->delete();
        return redirect()->back();
    }
}