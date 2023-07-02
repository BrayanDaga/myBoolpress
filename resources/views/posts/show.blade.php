@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2>Dettagli Post</h2>
        <table class="table table-striped table-bordered my-5">
            <tr>
                <td>Titolo</td>
                <td>{{ $post->title }}</td>
            </tr>
            <tr>
                <td>Sottotitolo</td>
                <td>{{ $post->subtitle }}</td>
            </tr>
            <tr>
                <td>Autore</td>
                <td>{{ $post->user->name }}</td>
            </tr>
            <tr>
                <td>Data di pubblicazione</td>
                <td>{{ $post->publication_date }}</td>
            </tr>
            <tr>
                <td>Testo</td>
                <td>{{ substr($post->text, 0, 500) . '...' }}</td>
            </tr>
            <tr>
                <td>Status del post</td>
                <td>{{ $post->infoPost->post_status ?? '' }}</td>
            </tr>
            <tr>
                <td>Status dei commenti</td>
                <td>{{ $post->infoPost->comment_status ?? '' }}</td>
            </tr>
            <tr>
                <td>Tags</td>
                <td>
                    @php
                        $tagNames = $post->tags->pluck('name')->toArray();
                        $tagString = implode(', ', $tagNames);
                    @endphp

                    {{ $tagString }}
                </td>
            </tr>
        </table>

        <div class="text-right">
            <a href="{{ route('posts.index') }}" class="btn btn-primary">Torna alla lista</a>
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Sei sicuro di voler eliminare questo articolo?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

        </div>

        <h2>Dettagli Commenti</h2>
        <table class="table table-striped table-bordered my-5">
            <tr>
                <td>Autore</td>
                <td>Testo</td>
            </tr>
            @foreach ($post->comments as $comment)
                <tr>
                    <td>{{ $comment->author }}</td>
                    <td>{{ $comment->text }}</td>
                </tr>
            @endforeach

        </table>

    </div>
@endsection
