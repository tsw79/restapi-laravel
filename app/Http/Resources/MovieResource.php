<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ActorResourceIdentifier;
use App\Http\Resources\ActorResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'type' => 'movies',
            'attributes' => [
                'title' => $this->title,
                'storyline' => $this->storyline,
                'genre' => $this->genre,
                'release_year' => $this->release_year,
                'runtime' => $this->runtime,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'actors' => [
                    'links' => [
                        'self'    => route('movies.relationships.actors', ['movie' => $this->id]),
                        'related' => route('movies.actors', ['movie' => $this->id]),
                    ],
                    'data' => ActorResourceIdentifier::collection(
                        $this->whenLoaded('actors')
                    )
                ],
            ]
        ];
    }

    /**
     * Adds the `included` top-level member to a single resource.
     */
    public function included($request)
    {
        return collect($this->relations())
            // filter any empty resources (preparing no empties for mapping, next)
            ->filter(function ($resource) {
                return null !== $resource->collection;
            })
            ->flatMap->toArray($request);
    }

    /**
     * @alias included()
     */
    public function withIncluded($request)
    {
        return $this->included($request);
    }

    /**
     * @override
     */
    public function with($request)
    {
        if ($this->included($request)->isNotEmpty()) {
            $this->with['included'] = $this->included($request);
        }
        return $this->with;
    }

    /**
     * Collects related resources
     *
     * @return
     */
    private function relations()
    {
        return [
            ActorResource::collection($this->whenLoaded('actors')),
        ];
    }
}
