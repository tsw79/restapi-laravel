<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ReviewCollection;
use App\Http\Requests\Review\CreateRequest;
use App\Http\Requests\Review\UpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = QueryBuilder::for(Review::class)
            ->allowedSorts(['review'])
            ->jsonPaginate();
        return new ReviewCollection($reviews);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $review = Review::create([
            'review' => $request->input('data.attributes.review')
        ]);

        return (new ReviewResource($review))
            ->response()
            ->header(
                'Location', route('reviews.show', ['review' => $review])
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Review $review)
    {
        $review->update($request->input('data.attributes'));
        return new ReviewResource($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response(null, 204);
    }
}
