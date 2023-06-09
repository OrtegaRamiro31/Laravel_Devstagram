<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'email' => ['required','unique:users,email,'.auth()->user()->id,'email','max:60'],
            'password' => ['nullable', 'min:6'],
            'current_password' => ['required','current_password', 'different:password'],
            // 'current_password' => ['required_with:password', 'different:password|filled|current_password'],
            // 'current_password' => ['different:password'],
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
        
        // Verificar si se llenó el campo password en el formulario
        if($request->filled('password')){
            // Asignamos la nueva password
            $usuario->password = Hash::make($request->password);
        }

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

