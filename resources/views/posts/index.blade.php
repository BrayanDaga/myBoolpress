@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif
        <table class="table table-striped table-bordered my-5">
            <thead>
                <tr>
                    <td>Titolo</td>
                    <td>Sottotitolo</td>
                    <td>Autore</td>
                    <td>Data di pubblicazione</td>
                    <td>Status Post</td>
                    <td>Status Commenti</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->subtitle }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->publication_date }}</td>
                        <td>
                            {{ $post->infoPost->post_status ?? '' }}
                        </td>
                        <td>{{ $post->infoPost->comment_status ?? '' }}</td>
                        <td><a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary"><i
                                    class="fas fa-search-plus"></i></a></td>
                        <td><a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary"><i
                                    class="fas fa-pencil-alt"></i></a></td>
                        <td>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Sei sicuro di voler eliminare questo articolo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right my-5">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Crea un nuovo post</a>
        </div>
    </div>
@endsection
