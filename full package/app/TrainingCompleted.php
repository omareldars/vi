<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingCompleted extends Model
{
    protected $table = 'training_completed';
    protected $fillable = ['course_id'];

}
