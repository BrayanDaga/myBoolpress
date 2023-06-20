@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-5">Elenco Post</h1>
        @foreach ($posts as $post)
            <section class="my-5">
                <h3>{{ $post->title }}</h3>
                <h4>{{ $post->subtitle }}</h4>
                <p>{{ substr($post->text, 0, 400) . '...' }}</p>
                <h5>Autore: {{ $post->user->name }}</h5>
            </section>
            <a href="{{ route('post', $post->id) }}" class="btn btn-primary">Leggi</a>
        @endforeach
    </div>
@endsection
