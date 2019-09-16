<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter\AlignFormatter;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show', 'rate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $articles = Article::query()->latest()->paginate(10);

        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required'
        ]);

        $article = $request->user()->articles()->create($request->only(['title', 'content']));

        return response()->json([
            'id' => $article->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ArticleResource
     */
    public function show($id)
    {
        $article = Article::query()->findOrFail($id);

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return ArticleResource
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required'
        ]);

        $article = Article::query()->where([
            'id' => $id,
            'user_id' => $request->user()->id
        ])->firstOrFail();

        $article->update($request->only('title', 'content'));

        return new ArticleResource($article);
    }

    /**
     * Rate an article
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'integer|min:1|max:10'
        ]);

        $data = [
            'rating' => $request->input('rating')
        ];

        $article = Article::query()->findOrFail($id);

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } else { // guest
            $data['guest_id'] = Str::uuid()->toString();
        }

        $rating = $article->ratings()->updateOrCreate($data);

        return response(['id' => $rating->id, 'rating' => $rating->rating], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $article = Article::query()->where([
            'id' => $id,
            'user_id' => Auth::id()
        ])->firstOrFail();

        $article->delete();

        return response('ok');
    }
}
