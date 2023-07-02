 @extends('layouts.app')
 @section('content')
     <div class="container">
         <h1 class="my-5">Elenco Post</h1>
         <section class="my-5">
             <h3>{{ $post->title }}</h3>
             <h4>{{ $post->subtitle }}</h4>
             <p>{{ substr($post->text, 0, 400) . '...' }}</p>
             <h5>Autore: {{ $post->user->name }}</h5>
             <div>
                 <p>{{ $post->publication_date }}</p>
                 <p>Post status: {{ $post->infoPost->post_status ?? '' }}</p>
                 <p>Comment statis: {{ $post->infoPost->comment_status ?? '' }}</p>
             </div>
             <h3>Commenti</h3>
             @foreach ($post->comments as $comment)
                 <div class="my-3">
                     <h6>{{ $comment->author }} <small>{{ $comment->created_at }}</small></h6>
                     <p>{{ $comment->text }}</p>
                 </div>
             @endforeach
         </section>
     </div>
 @endsection
