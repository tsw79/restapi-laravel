<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\Actor;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'storyline',
        'genre',
        'release_year',
        'runtime',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'release_year' => 'int',
        'runtime'      => 'int',
    ];

    public function actors() {
        return $this->belongsToMany(Actor::class);
    }

    // public function reviews() {
    //     return $this->hasMany(Review::class);
    // }
}
