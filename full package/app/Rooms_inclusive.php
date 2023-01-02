<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Rooms_inclusive extends Model
{
    protected $fillable = ['room_id','inclusive_id','user_added'];

    public function inclusive()
    {
        return $this->belongsTo(Inclusive::class,'inclusive_id','id');
    }
}

