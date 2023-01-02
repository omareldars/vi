<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['cat_id', 'name_en', 'name_ar', 'dsc_en', 'dsc_ar', 'img', 'user_id', 'price','approvedby'];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function productCategory(){
        return $this->belongsTo('App\ProductCategory','cat_id','id');
     }
    public function usrname()
    {
        $usrname = User::where('id', $this->user_id)
            ->first(['first_name_ar','last_name_ar','first_name_en','last_name_en']);
        return ($usrname) ;
    }

}

