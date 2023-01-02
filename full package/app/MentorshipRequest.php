<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MentorshipRequest extends Model
{
    protected $table = 'mentorship_requests';
    protected $fillable = ['mentor_id', 'user_id', 'comment', 'approved','admin_comment','admin_id','join_url','start_url','rate_comment','done'];
    protected $casts = ['zoom_date'  => 'date:Y-m-d H:i',];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function mentor(){
        return $this->belongsTo(User::class, 'mentor_id','id');
    }
}
