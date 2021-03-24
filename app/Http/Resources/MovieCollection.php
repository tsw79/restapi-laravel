<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;
use App\Http\Resources\MovieResource;

class MovieCollection extends ResourceCollection
{
    public $collects = MovieResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'included' => $this->mergeRelatedIncludeds($request),
        ];
    }

    /**
     * Merges all related resource objects from each resource in a collection
     */
    private function mergeRelatedIncludeds($request)
    {
        $includeds = $this->collection->flatMap->withIncluded($request)->unique()->values();
        return $includeds->isNotEmpty() ? $includeds : new MissingValue();
    }
}
