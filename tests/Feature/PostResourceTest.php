<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostResourceTest extends TestCase
{
    use RefreshDatabase;
    public function test_post_routes_protected_by_authentication()
    {
        // Creamos un usuario de prueba
        $user = User::factory()->create();

        // Creamos un post de prueba perteneciente al usuario
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Evaluamos la ruta index '/posts'
        $response = $this->get('/posts');
        $response->assertRedirect('/login');

        // Evaluamos la ruta create '/posts/create'
        $response = $this->get('/posts/create');
        $response->assertRedirect('/login');

        // Evaluamos la ruta store '/posts' (POST request)
        $response = $this->post('/posts', ['title' => 'Nuevo post']);
        $response->assertRedirect('/login');

        // Evaluamos la ruta show '/posts/{post}'
        $response = $this->get('/posts/' . $post->id);
        $response->assertRedirect('/login');

        // Evaluamos la ruta edit '/posts/{post}/edit'
        $response = $this->get('/posts/' . $post->id . '/edit');
        $response->assertRedirect('/login');

        // Evaluamos la ruta update '/posts/{post}' (PUT request)
        $response = $this->put('/posts/' . $post->id, ['title' => 'Post actualizado']);
        $response->assertRedirect('/login');

        // Evaluamos la ruta delete '/posts/{post}' (DELETE request)
        $response = $this->delete('/posts/' . $post->id);
        $response->assertRedirect('/login');
    }
}
