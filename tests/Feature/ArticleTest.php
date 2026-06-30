<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Admin can access article index page.
     */
    public function test_admin_can_access_article_index_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('articles.index'));

        $response->assertStatus(200);
    }

    /**
     * Test Admin can create article.
     */
    public function test_admin_can_create_article(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('articles.store'), [
            'title' => 'Tips Sehat Balita',
            'content' => 'Lorem ipsum dolor sit amet.',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('articles', [
            'title' => 'Tips Sehat Balita',
            'content' => 'Lorem ipsum dolor sit amet.',
            'user_id' => $admin->id,
        ]);
    }
}
