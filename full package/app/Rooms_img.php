<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rooms_img extends Model
{
    //protected $table='rooms_imgs';
    protected $fillable = ['room_id','img_url','user_added'];
}
