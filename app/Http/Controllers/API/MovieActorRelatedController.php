<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Resources\ActorCollection;

class MovieActorRelatedController extends Controller
{
    public function index(Movie $movie)
    {
        return new ActorCollection($movie->actors);
    }
}
