<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function  test_user_can_edit_own_post()
    {
        // Creamos un usuario de prueba
        $user = User::factory()->create();
        // Creamos un post perteneciente al usuario
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Intentamos acyualizar el post
        $response =  $this->actingAs($user)->put(route('posts.update', $post), [
            'title' => 'Nuevo título',
            'subtitle' => 'Nuevo título',
            'publication_date' => '2023-01-01',
            'text' => 'Nuevo contenido',
            'user_id' => $user->id,
            'post_status' => 'private',
            'comment_status' => 'closed'
        ]);


        // Verificamos que la respuesta sea una redirección exitosa (código 302)
        $response->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Nuevo título'
        ]);
    }

    public function  test_user_cannot_edit_other_users_post()
    {
        // Creamos dos usuarios de prueba
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Creamos un post perteneciente al usuario 1
        $post = Post::factory()->create(['user_id' => $user1->id]);

        // Autenticamos al usuario 2
        $this->actingAs($user2);

        // Intentamos actualizar el post del usuario 1
        $response = $this->put(route('posts.update', $post), [
            'title' => 'Nuevo título',
            'subtitle' => 'Nuevo título',
            'publication_date' => '2023-01-01',
            'text' => 'Nuevo contenido',
            'user_id' => $user1->id,
            'post_status' => 'private',
            'comment_status' => 'closed'
        ]);

        // Verificamos que la respuesta sea un error 403 Forbidden
        $response->assertStatus(403);
    }


    public function test_user_can_delete_own_post()
    {
        // Creamos un usuario de prueba
        $user = User::factory()->create();

        // Creamos un post perteneciente al usuario
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Autenticamos al usuario
        $this->actingAs($user);

        // Intentamos eliminar el post
        $response = $this->delete(route('posts.destroy', $post));

        // Verificamos que la respuesta sea una redirección exitosa (código 302)
        $response->assertRedirect();

        // Verificamos que el post haya sido eliminado de la base de datos
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_user_cannot_delete_other_users_post()
    {
        // Creamos dos usuarios de prueba
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Creamos un post perteneciente al usuario 1
        $post = Post::factory()->create(['user_id' => $user1->id]);

        // Autenticamos al usuario 2
        $this->actingAs($user2);

        // Intentamos eliminar el post del usuario 1
        $response = $this->delete(route('posts.destroy', $post));

        // Verificamos que la respuesta sea un error 403 Forbidden
        $response->assertStatus(403);
    }
}
