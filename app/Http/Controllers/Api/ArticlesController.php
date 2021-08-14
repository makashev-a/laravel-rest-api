<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $articles = Article::all();

        return response()->json($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request_data = $request->only(['title', 'content']);

        $validator = Validator::make($request_data, [
            "title" => "required|string",
            "content" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->messages()
            ])->setStatusCode(422);
        }

        $article = Article::create([
            "title" => $request->title,
            "content" => $request->content
        ]);

        return response()->json([
            "status" => true,
            "article" => $article
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                "status" => false,
                "message" => "The article was not found"
            ], 404);
        }

        return response()->json($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(Request $request, $id)
    {
        $request_data = $request->only(['title', 'content']);

        $validator = Validator::make($request_data, [
            "title" => "required|string",
            "content" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->messages()
            ])->setStatusCode(422);
        }

        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                "status" => false,
                "errors" => $validator->messages()
            ])->setStatusCode(404, 'The article was not found');
        }

        $article->update([
            'title' => $request_data['title'],
            'content' => $request_data['content']
        ]);

        return response()->json([
            "status" => true,
            "message" => 'The article was succesfully updated',
            "article" => $article
        ])->setStatusCode(200, 'The article was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'status' => false,
                'message' => 'The article was not found'
            ])->setStatusCode(404, 'The article was not found');
        }

        $article->delete();

        return response()->json([
            'id' => $id,
            'status' => true,
            'message' => 'The article was successfully deleted'
        ])->setStatusCode(200, 'The article was successfully deleted');
    }
}
