<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_all_posts()
    {
        $user = User::factory()->create(); // Crear un usuario de prueba

        $post1 = Post::factory()->create([
            'user_id' => $user->id // Asignar el ID del usuario al post
        ]);
        $post2 = Post::factory()->create([
            'user_id' => $user->id // Asignar el ID del usuario al post
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($post1->title); // Verificar que se muestra el título del post en la página
        $response->assertSee($post2->title); // Verificar que se muestra el título del post en la página
    }

    public function test_single_post_page_displays_specific_post()
    {
        $user = User::factory()->create();
        // Creamos un post de ejemplo
        $post = Post::factory()->create(['title' => 'Mi post de prueba', 'user_id' => $user->id]);

        // Realizamos una solicitud GET a la ruta de un solo post
        $response = $this->get('/post/' . $post->id);

        // Verificamos que la respuesta tenga un estado 200 (OK)
        $response->assertStatus(200);

        // Verificamos que el título del post esté presente en la respuesta
        $response->assertSee($post->title);
    }
}