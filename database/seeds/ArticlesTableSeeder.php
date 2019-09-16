<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Article::class, 10)->create()
            ->each(function ($article) {
                $article->ratings()->save(factory(App\Rating::class)->make());
            });
    }
}
