<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Service extends Model
{
    protected $fillable = ['service_category_id', 'name_en', 'name_ar','price', 'description_en', 'description_ar', 'img_url'];

    public function serviceCategory(){
       return $this->belongsTo(ServiceCategory::class);
    }
    public function totalRate()
    {
        $rates = ServicesRequests::where('service_id', $this->id)->avg('rate');
        return ($rates??0);
    }
    public function totalRequests()
    {
        $count = ServicesRequests::where('approved','Yes')->where('service_id', $this->id)->count();
        return ($count??0);
    }
    public function myRate()
    {
        $rate = ServicesRequests::where('service_id', $this->id)->where('user_id',Auth::id())->avg('rate');
        return ($rate??0);
    }
}