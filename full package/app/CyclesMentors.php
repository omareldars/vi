<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class CyclesMentors extends Model
{
    use Auditable;
    protected $table = 'cycles_mentors';
    protected $fillable = ['user_id', 'cycle_id'];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function mrating(){
        return (MentorshipRequest::where('mentor_id',$this->user_id)->avg('rating'));
    }
}
