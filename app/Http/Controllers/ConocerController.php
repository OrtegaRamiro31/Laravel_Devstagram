<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConocerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
         // Obtener a quienes seguimos
         $ids = auth()->user()->followings->pluck('id')->toArray();

         // WhereIn compara con cada valor del arreglo. Obtenemos a quienes no seguimos
         $posts = Post::whereNotIn('user_id', $ids)->paginate(20);
        
        return view('home', [
         'posts' => $posts,
         'titulo' => 'Conoce los posts de otros usuarios',
        ]);   
    }
}
