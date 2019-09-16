<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RateArticleTest extends TestCase
{
    protected $article;

    public function setUp(): void
    {
        parent::setUp();

        $this->article = factory(Article::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);
    }

    /**
     * @test
     */
    public function guest_can_rate_article()
    {
        $previousCount = $this->article->ratings()->count();

        $rating = rand(1, 10);

        $response = $this->post('/api/articles/' . $this->article->id . '/rating', [
            'rating' => $rating
        ]);

        $response->assertStatus(201);

        $response->assertJson(['rating' => $rating]);

        $this->assertCount($previousCount + 1, $this->article->ratings);
    }

    /**
     * @test
     */
    public function authenticated_user_can_rate_article()
    {
        $this->actingAs(factory(User::class)->create());

        $previousCount = $this->article->ratings()->count();

        $rating = rand(1, 10);

        $response = $this->post('/api/articles/' . $this->article->id . '/rating', [
            'rating' => $rating
        ]);

        $response->assertStatus(201);

        $response->assertJson(['rating' => $rating]);

        $this->assertCount($previousCount + 1, $this->article->ratings);
    }
}
