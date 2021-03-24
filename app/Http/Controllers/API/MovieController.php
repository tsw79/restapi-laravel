<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieCollection;
use App\Http\Requests\Movie\CreateRequest;
use App\Http\Requests\Movie\UpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = QueryBuilder::for(Movie::class)
            ->allowedIncludes('actors')
            ->allowedSorts(['title'])
            ->jsonPaginate();
        return new MovieCollection($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Movie\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $movie = Movie::create([
            'title'        => $request->input('data.attributes.title'),
            'storyline'    => $request->input('data.attributes.storyline'),
            'genre'        => $request->input('data.attributes.genre'),
            'release_year' => $request->input('data.attributes.release_year'),
            'runtime'      => $request->input('data.attributes.runtime')
        ]);

        return (new MovieResource($movie))
            ->response()
            ->header(
                'Location', route('movies.show', ['movie' => $movie])
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  string $movie    Movie ID
     * @return \Illuminate\Http\Response
     */
    public function show($movie)
    {
        $qry = QueryBuilder::for(Movie::where('id', $movie))
            ->allowedIncludes('actors')
            ->firstOrFail();
        return new MovieResource($qry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Movie\UpdateRequest  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Movie $movie)
    {
        $movie->update($request->input('data.attributes'));
        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response(null, 204);
    }
}
