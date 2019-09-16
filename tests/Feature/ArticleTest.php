<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    protected $user;

    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function a_user_can_create_article()
    {
        $this->actingAs($this->user, 'api');

        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph(10, true),
        ];

        $response = $this->post('/api/articles', $data);

        $response->assertStatus(201);

        $response->assertJsonStructure(['id']);

        $this->assertDatabaseHas('articles', $data);
    }

    /**
     * @test
     */
    public function guests_can_not_create_article()
    {
        $response = $this->post('/api/articles', [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph(10, true),
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function author_can_update_an_article(){
        $this->actingAs($this->user, 'api');

        $article = $this->user->articles()->save(factory(Article::class)->make());

        $newTitle = $this->faker->title;
        $newContent = $this->faker->sentences(10, true);

        $data = [
            'title' => $newTitle,
            'content' => $newContent
        ];

        $response = $this->put('/api/articles/'.$article->id, $data);

        $response->assertStatus(200);

        $data['id'] = $article->id;

        $this->assertDatabaseHas('articles', $data);
    }

    /** @test */
    public function authors_can_not_update_another_authors_article(){
        // another author
        $this->actingAs(factory(User::class)->create(), 'api');

        $article = $this->user->articles()->save(factory(Article::class)->make());

        $newTitle = $this->faker->title;
        $newContent = $this->faker->sentences(10, true);

        $data = [
            'title' => $newTitle,
            'content' => $newContent
        ];

        $response = $this->put('/api/articles/'.$article->id, $data);

        $response->assertStatus(404);
    }

    /** @test */
    public function author_can_delete_his_article(){
        $this->actingAs($this->user, 'api');

        $article = $this->user->articles()->save(factory(Article::class)->make());

        $response = $this->delete('/api/articles/'.$article->id);

        $response->assertStatus(200);

        $this->assertSoftDeleted($article);
    }

    /** @test */
    public function articles_can_be_viewed()
    {
        $articles = $this->user->articles()->createMany(factory(Article::class, 10)->make()->toArray());

        $response = $this->get('/api/articles');

        $response->assertStatus(200);

        $response->assertSee($articles[0]->title);
    }

    /** @test */
    public function an_article_can_be_viewed()
    {
        $article = $this->user->articles()->save(factory(Article::class)->make());

        $response = $this->get('/api/articles/' . $article->id);

        $response->assertStatus(200);

        $response->assertSee($article->content);
        $response->assertJsonStructure(['id', 'title', 'slug', 'content', 'created_at']);
    }
}
