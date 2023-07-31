<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\TagStore;
use App\Http\Requests\Tag\TagUpdate;
use App\Http\Resources\TagResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TagController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TagResource::collection(auth()->user()->tags()->paginate(5));
    }

    public function store(TagStore $request): Response
    {
        $inputs = $request->validated();
        auth()->user()->tags()->create($inputs);

        return response()->noContent();
    }

    public function show(string $id): TagResource
    {
        return new TagResource(auth()->user()->tags()->findOrFail($id));
    }

    public function update(TagUpdate $request, string $id): Response
    {
        $inputs = $request->validated();

        auth()->user()->tags()->findOrFail($id)->update($inputs);

        return response()->noContent();
    }

    public function destroy(string $id): Response
    {
        auth()->user()->tags()->findOrFail($id)->delete();

        return response()->noContent();
    }
}
