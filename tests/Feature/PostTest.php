<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_homePage_displays_allPosts(): void
    {
        // Creamos algunos posts de ejemplo
        $post1 = Post::factory()->create(['title' => 'Post 1']);
        $post2 = Post::factory()->create(['title' => 'Post 2']);

        // Realizamos una solicitud GET a la página de inicio
        $response = $this->get('/');

        // Verificamos que la respuesta tenga un estado 200 (OK)
        $response->assertStatus(200);

        // Verificamos que ambos títulos de los posts estén presentes en la respuesta
        $response->assertSee($post1->title);
        $response->assertSee($post2->title);
    }
    public function test_single_post_page_displays_specificPost()
    {
        // Creamos un post de ejemplo
        $post = Post::factory()->create(['title' => 'Mi post de prueba']);

        // Realizamos una solicitud GET a la ruta de un solo post
        $response = $this->get('/post/' . $post->id);

        // Verificamos que la respuesta tenga un estado 200 (OK)
        $response->assertStatus(200);

        // Verificamos que el título del post esté presente en la respuesta
        $response->assertSee($post->title);
    }
}
