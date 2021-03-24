<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieActorRequest;
use App\Models\Movie;
use App\Http\Resources\ActorResourceIdentifier;

class MovieActorController extends Controller
{
    public function index(Movie $movie)
    {
        return ActorResourceIdentifier::collection($movie->actors);
    }

    public function update(MovieActorRequest $request, Movie $movie)
    {
        $ids = $request->input('data.*.id');
        $movie->actors()->sync($ids);
        return response(null, 204);
    }
}
