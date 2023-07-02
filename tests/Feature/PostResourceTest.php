<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostResourceTest extends TestCase
{
    use RefreshDatabase, WithFaker, AuthenticatesUsers;

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
    public function test_can_create_post()
    {
        $user = User::factory()->create();

        $postData = [
            'title' => $this->faker->sentence(1),
            'subtitle' => $this->faker->sentence(1),
            'text' => $this->faker->paragraph(1),
            'user_id' => $user->id,
            'publication_date' => now()->toDateString(),
            'post_status' => 'public',
            'comment_status' => 'open',
        ];

        $response = $this->actingAs($user)->post('/posts', $postData);

        $response->assertRedirect();
        $this->assertDatabaseHas('info_posts', [
            'post_id' => Post::first()->id,
            'post_status' => 'public',
            'comment_status' => 'open',
        ]);

        $post = Post::first();
        $this->assertNotNull($post->infoPost);
        $this->assertEquals($post->id, $post->infoPost->post_id);
        $this->assertContains($post->infoPost->comment_status, ['open', 'closed', 'private']);
        $this->assertContains($post->infoPost->post_status, ['public', 'private', 'draft']);
    }



    public function test_can_update_post()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba
        $post = Post::factory()->create(['user_id' => $user->id]); // Crea un post de prueba asociado al usuario

        $updatedData = [
            'title' => $this->faker->sentence(1),
            'subtitle' => $this->faker->sentence(1),
            'text' => $this->faker->paragraph(1),
            'publication_date' => now()->toDateString(),
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->put('/posts/' . $post->id, $updatedData);

        $response->assertRedirect(); // Verifica que se haya redireccionado correctamente
        $this->assertDatabaseHas('posts', $updatedData); // Verifica que los datos estén en la base de datos
    }

    public function test_can_delete_post()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba
        $post = Post::factory()->create(['user_id' => $user->id]); // Crea un post de prueba asociado al usuario

        $response = $this->actingAs($user)->delete('/posts/' . $post->id);

        $response->assertStatus(302); // Verifica que se haya redireccionado correctamente
        $this->assertDatabaseMissing('posts', ['id' => $post->id]); // Verifica que los datos no estén en la base de datos
    }

    public function test_it_validates_user_id_is_required_and_exists()
    {

        $user = User::factory()->create(); // Crea un usuario de prueba

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'Example Title',
            'subtitle' => 'Example Subtitle',
            'text' => 'Example Text',
            'publication_date' => now()->toDateString(),
            'user_id' => null,
        ]);


        $response->assertSessionHasErrors('user_id');

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'Example Title',
            'subtitle' => 'Example Subtitle',
            'text' => 'Example Text',
            'publication_date' => now()->toDateString(),
            'user_id' => 999,
        ]);

        $response->assertSessionHasErrors('user_id');
    }

    /** @test */
    public function testItValidatesTitleIsRequiredAndMaximumLengthIs150Characters()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('posts.store'), [
            'title' => null,
            'subtitle' => 'Example Subtitle',
            'text' => 'Example Text',
            'publication_date' => now(),
            'user_id' => 1,
        ]);

        $response->assertSessionHasErrors('title');

        $title = Str::random(151);
        $response = $this->post(route('posts.store'), [
            'title' => $title,
            'subtitle' => 'Example Subtitle',
            'text' => 'Example Text',
            'publication_date' => now(),
            'user_id' => 1,
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function testItValidatesSubtitleIsRequiredAndMaximumLengthIs100Characters()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('posts.store'), [
            'title' => 'Example Title',
            'subtitle' => null,
            'text' => 'Example Text',
            'publication_date' => now(),
            'user_id' => 1,
        ]);

        $response->assertSessionHasErrors('subtitle');

        $subtitle = Str::random(101);
        $response = $this->post(route('posts.store'), [
            'title' => 'Example Title',
            'subtitle' => $subtitle,
            'text' => 'Example Text',
            'publication_date' => now(),
            'user_id' => 1,
        ]);

        $response->assertSessionHasErrors('subtitle');
    }

    /** @test */
    public function testItValidatesTextIsRequiredAndMaximumLengthIs150Characters()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('posts.store'), [
            'title' => 'Example Title',
            'subtitle' => 'Example Subtitle',
            'text' => null,
            'publication_date' => now(),
            'user_id' => 1,
        ]);

        $response->assertSessionHasErrors('text');

        $text = Str::random(151);
        $response = $this->post(route('posts.store'), [
            'title' => 'Example Title',
            'subtitle' => 'Example Subtitle',
            'text' => $text,
            'publication_date' => now(),
            'user_id' => 1,
        ]);

        $response->assertSessionHasErrors('text');
    }

    /** @test */
    public function test_publication_date_is_date()
    {
        $postData = [
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'text' => $this->faker->paragraph,
            'user_id' => User::factory()->create()->id,
            'publication_date' => 'invalid-date', // Fecha inválida
        ];

        $errorMessage = Lang::get('validation.date', [
            'attribute' => trans('validation.attributes.publication_date')
        ]);

        $response = $this->post('/posts', $postData)
            ->withErrors(['publication_date' => $errorMessage]);

        // Verifica que la respuesta sea una redirección
        $this->assertTrue($response->isRedirect());

        // Realiza una nueva solicitud GET a la página de creación
        $response = $this->get('/posts/create');

        // Verifica que los errores de validación se muestren en la página
        $response->assertSessionHasErrors('publication_date');
    }
}
