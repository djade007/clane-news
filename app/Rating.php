<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = ['id'];


    protected static function boot()
    {
        parent::boot();


        self::created(function($rating) {
            $article = Article::query()->find($rating->article_id);

            if(!$article)
                return;

            // recalculate total ratings
            $article->update([
                'average_rating' => $article->ratings->sum('rating') / $article->ratings->count() / 100
            ]);
        });
    }
}
