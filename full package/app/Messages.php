<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model
{
    protected $fillable = ['name','email','phone','subject','message','read','userip','user_id','replyBy','reSubject','reMessage','internal_id'];
    use SoftDeletes;

}
