<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_delete_other_users_post()
    {
        // Creamos dos usuarios de prueba
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Creamos un post de prueba perteneciente al usuario 1
        $post = Post::factory()->create(['user_id' => $user1->id]);

        // Autenticamos al usuario 2
        $this->actingAs($user2);

        // Evaluamos la política para eliminar el post del usuario 1
        $this->assertFalse($user2->can('delete', $post));
    }
}
