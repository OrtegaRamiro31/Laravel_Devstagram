<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
        return view('perfil.index');
    }

    public function store(Request $request){

        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:twitter,editar-perfil'],
            'email' => ['required','unique:users,email,'.auth()->user()->email,'email','max:60'],
        ]);

        $nombreImagen = '';

        if($request->imagen){
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
    
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        } 

        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';

        // Eliminar imágen del servidor
        if(auth()->user()->imagen){
            unlink(public_path('perfiles') . '/' . auth()->user()->imagen);
        }
        // Guardar cambios
        $usuario->save();

        // Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}

