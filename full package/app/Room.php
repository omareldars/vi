<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Room extends Model
{
    protected $fillable = ['name_en','name_ar','type_trans', 'price', 'discount','desc_en', 'desc_ar','video_link', 'published','user_added'];

    public function User()
    {
        return $this->belongsTo(User::class,'user_added','id');
    }
}
