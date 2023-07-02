<?php

namespace Tests\Unit;

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
}
