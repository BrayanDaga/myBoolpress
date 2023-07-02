<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;



    public function test_post_has_user_relationship()
    {
        // Creamos un usuario de prueba
        $user = User::factory()->create();

        // Creamos un post relacionado con el usuario
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Verificamos que el post tenga una relación con el usuario
        $this->assertInstanceOf(User::class, $post->user);
        $this->assertEquals($user->id, $post->user->id);
    }

    public function test_post_has_comments_relationship()
    {
        // Creamos un usuario de prueba
        $user = User::factory()->create();

        // Creamos un post relacionado con el usuario
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Creamos dos comentarios relacionados con el post
        $comment1 = Comment::factory()->create(['post_id' => $post->id]);
        $comment2 = Comment::factory()->create(['post_id' => $post->id]);

        // Verificamos que el post tenga una relación con los comentarios
        $this->assertInstanceOf(Collection::class, $post->comments);
        $this->assertCount(2, $post->comments);
        $this->assertTrue($post->comments->contains($comment1));
        $this->assertTrue($post->comments->contains($comment2));
    }

    public function test_post_has_tags_relationship()
    {
        // Creamos un usuario de prueba
        $user = User::factory()->create();

        // Creamos un post relacionado con el usuario
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Creamos dos tags relacionados con el post
        $tags = Tag::factory()->count(3)->create();

        $post->tags()->attach($tags);
        // Verificamos que el post tenga una relación con los comentarios
        $this->assertEquals(3, $post->tags()->count());
        $tag1 = Tag::first();
        $this->assertTrue($post->tags->contains($tag1));
    }

    public function testPostWithTagsCanBeSavedAndRetrieved()
    {
        // Crea un post
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        // Crea algunas tags
        $tags = Tag::factory()->count(3)->create();

        // Asocia las tags al post
        $post->tags()->attach($tags);

        // Guarda el post en la base de datos
        $savedPost = Post::with('tags')->find($post->id);

        // Verifica que el post se haya guardado correctamente y las tags estén asociadas
        $this->assertEquals($post->id, $savedPost->id);
        $this->assertEquals(3, $savedPost->tags->count());
    }
}
