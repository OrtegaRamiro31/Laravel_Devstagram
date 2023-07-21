<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function __invoke()
    {
        // Obtener a quienes seguimos
        $ids = auth()->user()->followings->pluck('id')->toArray();
        // WhereIn compara con cada valor del arreglo
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

       return view('home', [
        'posts' => $posts,
        'titulo' => 'Página principal',
       ]);   
    }
}
