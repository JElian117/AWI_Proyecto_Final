<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class usuariosController extends Controller
{
    public function index() {
        $usuarios = User::all();
        return view('crudUsuarios')->with('usuarios', $usuarios);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'string|max:255',
            'apellidoM' => 'string|max:255',
            'rol' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'psw' => 'required|string',
        ]);

        $nuevoUsuario = new User();
        $nuevoUsuario->name = $request->nombre;
        $nuevoUsuario->apellidoP = $request->apellidoP;
        $nuevoUsuario->apellidoM = $request->apellidoM;
        $nuevoUsuario->rol = $request->rol;
        $nuevoUsuario->email = $request->email;
        $nuevoUsuario->password = bcrypt($request->psw);
        $nuevoUsuario->save();

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id){
        $usuario = User::find($id);
        return view('editarUsuarios', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'string|max:255',
            'apellidoM' => 'string|max:255',
            'rol' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        ]);

        $usuario = User::find($id);
        $usuario->name = $request->nombre;
        $usuario->apellidoP = $request->apellidoP;
        $usuario->apellidoM = $request->apellidoM;
        $usuario->rol = $request->rol;
        $usuario->email = $request->email;
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }
    
    public function delete($id){
        $usuario = User::find($id);
        $usuario->delete();
        return redirect()->back();
    }
}
