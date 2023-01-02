<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrainingContent extends Model
{
    protected $fillable = ['training_id', 'title', 'dsc', 'arr', 'content', 'user_id',];

    function user() {
        return $this->belongsTo(User::class);
    }
    function done() {
        return(TrainingCompleted::where('training_id',$this->id)->where('user_id',Auth::id())->pluck('updated_at')[0]??null);
    }
}
