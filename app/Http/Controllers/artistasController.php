<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artista;

class artistasController extends Controller
{
    public function index() {
        $artistas = Artista::all();
        return view('crudArtistas')->with('artistas', $artistas);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Cambiado a 'name'
            'uri' => 'required|string',
            'image_url' => 'nullable|string', // Cambiado a 'image_url'
        ]);

        $nuevoArtista = new Artista();
        $nuevoArtista->name = $request->name; // Cambiado a 'name'
        $nuevoArtista->uri = $request->uri;
        $nuevoArtista->image_url = $request->image_url; // Cambiado a 'image_url'
        $nuevoArtista->save();

        return redirect()->back()->with('success', 'Artista creado exitosamente.');
    }

    public function edit($id){
        $artista = Artista::find($id);
        return view('editarArtista', compact('artista'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Cambiado a 'name'
            'uri' => 'required|string',
            'image_url' => 'nullable|string', // Cambiado a 'image_url'
        ]);

        $artista = Artista::find($id);
        $artista->name = $request->name; // Cambiado a 'name'
        $artista->uri = $request->uri;
        $artista->image_url = $request->image_url; // Cambiado a 'image_url'
        $artista->save();

        return redirect()->route('artistas.index')->with('success', 'Artista actualizado exitosamente.');
    }
    
    public function delete($id){
        $artista = Artista::find($id);
        $artista->delete();
        return redirect()->back();
    }
}
