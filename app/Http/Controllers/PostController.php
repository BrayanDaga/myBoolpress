<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\InfoPost;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::user()->id)->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();


        // Crear el post
        $postData = [
            'title' => $data['title'],
            'subtitle' => $data['subtitle'],
            'text' => $data['text'],
            'user_id' => $data['user_id'],
            'publication_date' => $data['publication_date'],
        ];
        $post = Post::create($postData);

        // Crear el InfoPost y establecer las relaciones
        $infoPostData = [
            'post_id' => $post->id,
            'comment_status' => $data['comment_status'],
            'post_status' => $data['post_status'],
        ];
        $infoPost = InfoPost::create($infoPostData);

        // Establecer la relación entre el post y el infoPost
        $post->infoPost()->save($infoPost);
        // // salvataggio Tags
        if (!empty($data["tags"])) {
            $post->tags()->attach($data["tags"]);
        }
        return redirect()->route('posts.index')->with('message', 'Post creado correctamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        $tags = Tag::all();
        return view('posts.show', compact('post', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        $tags = Tag::all();
        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        if (Gate::denies('edit-post', $post)) {
            abort(403); // Retorna un error 403 (Forbidden) si no tiene permiso
        }

        $data = $request->validated();

        $postData = [
            'title' => $data['title'],
            'subtitle' => $data['subtitle'],
            'text' => $data['text'],
            'user_id' => $data['user_id'],
            'publication_date' => $data['publication_date'],
        ];
        $post->update($postData);

        $infoPostData = [
            'comment_status' => $data['comment_status'],
            'post_status' => $data['post_status'],
        ];
        $post->infoPost()->update($infoPostData);


        // modifica tags
        if (empty($data["tags"])) {
            $post->tags()->detach();
        } else {
            $post->tags()->sync($data["tags"]);
        }
        return redirect()->route('posts.index')->with('message', 'Post modificato correttamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Gate::denies('delete-post', $post)) {
            abort(403); // Retorna un error 403 (Forbidden) si no tiene permiso
        }
        $post->delete();
        return redirect()->route('posts.index')->with('message', 'Post elminato correttamente!');
    }
}
