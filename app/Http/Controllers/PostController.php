<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
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
        $post = new Post();
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->text = $request->text;
        $post->publication_date = $request->publication_date;
        $post->user_id = Auth::user()->id;
        $post->save();
        return redirect()->route('posts.index')->with('message', 'Post creato correttamente!');

        // salvataggio infoPost
        // $data["post_id"] = $post->id; //devo specificare il nuovo post_id con l'id del post creato
        // $infoPost = new infoPost();
        // $infoPost->fill($data);
        // $infoPost->save();

        // // salvataggio Tags
        // if ($infoPost->save()) {
        //     if (!empty($data["tags"])) {
        //         $post->tags()->attach($data["tags"]);
        //     }
        // }


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
        // modifica post
        $data = $request->all();
        $post->update($data);

        // modifica infoPost

        // // $infoPost = InfoPost::where('post_id', $post->id)->first();
        // $infoPost = $post->infoPost;
        // $data["post_id"] = $post->id; //devo specificare il post_id con l'id del post modificato
        // $infoPost->update($data);

        // // modifica tags
        // if (empty($data["tags"])) {
        //     $post->tags()->detach();
        // } else {
        //     $post->tags()->sync($data["tags"]);
        // }

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