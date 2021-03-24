<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Http\Resources\ActorResource;
use App\Http\Resources\ActorCollection;
use App\Http\Requests\Actor\CreateRequest;
use App\Http\Requests\Actor\UpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actors = QueryBuilder::for(Actor::class)
            ->allowedSorts(['name'])
            ->jsonPaginate();
        return new ActorCollection($actors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Actor\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $actor = Actor::create([
            'name' => $request->input('data.attributes.name')
        ]);

        return (new ActorResource($actor))
            ->response()
            ->header(
                'Location', route('actors.show', ['actor' => $actor])
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {
        return new ActorResource($actor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Actor\UpdateRequest  $request
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Actor $actor)
    {
        $actor->update($request->input('data.attributes'));
        return new ActorResource($actor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();
        return response(null, 204);
    }
}
