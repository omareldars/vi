<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['user_id','type','days','dfrom','dto','tfrom','tto','notes','active'];
    protected $casts = ['dfrom' => 'date:Y-m-d', 'dto' => 'date:Y-m-d', 'tfrom'=> 'time:H:i', 'tto' => 'time:H:i','days'=>'array',];

}
