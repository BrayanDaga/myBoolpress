<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test the index method of PostController.
     *
     * @return void
     */
    public function testIndex()
    {
        // Creamos un usuario de prueba
        $user = User::factory()->create();

        // Autenticamos al usuario
        $this->actingAs($user);

        // Creamos algunos posts para el usuario autenticado
        $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);

        // Realizamos una solicitud GET a la ruta 'posts.index'
        $response = $this->get(route('posts.index'));

        // Verificamos que la respuesta sea exitosa (código de estado 200)
        $response->assertOk();

        // Verificamos que la vista 'posts.index' se haya cargado
        $response->assertViewIs('posts.index');

        // Verificamos que los posts se pasen a la vista correctamente
        $response->assertViewHas('posts', $posts);
    }
}