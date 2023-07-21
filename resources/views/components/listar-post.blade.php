<div>
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
            <div>
                <a href="{{route('posts.show', ['post' => $post, 'user' => $post->user])}}">
                    <img src="{{asset('uploads') . '/' . $post->imagen}}" alt="Imagen del post {{$post->titulo}}"/>
                </a>
                <div class="p-3">
                @auth
                    <div class="flex justify-around">
                        <livewire:like-post :post="$post" />
                        <p class="font-bold">{{$post->comentarios->count()}} <span class="font-normal">@choice('comentario|comentarios', $post->comentarios->count())</span></p>
                    </div>
                @endauth
            </div>   
                
            </div>         
            @endforeach
        </div>
        <div class="my-10 ">
            {{$posts->links('pagination::tailwind')}}
        </div>
    @else
        <p class="text-center">No hay posts, sigue a alguien para ver posts</p>
    @endif
</div>