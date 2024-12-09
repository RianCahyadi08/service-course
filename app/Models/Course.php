<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name', 'thumbnail', 'type', 'status', 'price', 'level', 'description', 'is_certificate', 'mentor_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];

    public function mentor() {
        return $this->belongsTo('App\Mentor');
    }

    public function chapters() {
        return $this->hasMany('App\Chapter')->orderBy('id', 'asc');
    }

    public function images() {
        return $this->hasMany('App\ImageCourse')->orderBy('id', 'desc');
    }
}
