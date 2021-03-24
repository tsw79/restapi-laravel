<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use App\Models\User;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review',
    ];

    public function review() {
        return $this->belongsTo(Movie::class);
    }

    public function reviews() {
        return $this->review();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function users()  {
        return $this->user();
    }
}
