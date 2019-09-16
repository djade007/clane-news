<?php

namespace Tests\Unit;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function test_articles_total()
    {
        factory(Article::class, 20)->create();

        $this->assertCount(20, Article::all());
    }
}
