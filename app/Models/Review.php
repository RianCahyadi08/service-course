<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    protected $fillable = [
        'user_id', 'rating', 'note', 'course_id'
    ];

    public function course() {
        return $this->belongsTo('App\Course');
    }
}
