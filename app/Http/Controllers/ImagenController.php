<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //
    public function store(Request $request){
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000);

        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);
        
        return response()->json(['imagen' => $nombreImagen]);
    }

    public function delete(){
        $imagenes = glob(('uploads') . '/*');
        $imagenesDB = Post::pluck('imagen')->toArray();

        foreach($imagenes as $imagen){
            if(!in_array(basename($imagen), $imagenesDB)){
                unlink($imagen);
            }
        }

        return response()->json(['msg' => 'Imágenes eliminadas correctamente']);
    }
}
