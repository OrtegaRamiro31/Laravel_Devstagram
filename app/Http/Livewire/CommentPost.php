<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comentario;

class CommentPost extends Component
{
    public $post;
    public $user;
    public $comentario;
    public $reactiveComments;
    
    public function mount($post, $user){
        $this->post = $post;
        $this->user = $user;
        $this->reactiveComments =  $post->comentarios()->orderBy('updated_at', 'DESC')->get();
    }

    public function comment(){
        $this->validate([
            'comentario' => 'required|max:255'
        ]);
        
        $newComment = Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
            'comentario' => $this->comentario,
        ]);

        $this->reactiveComments->push($newComment);
    }

    public function render()
    {
        return view('livewire.comment-post');
    }
}
