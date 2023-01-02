<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicesRequests extends Model
{
    protected $table = 'services_requests';
    protected $fillable = ['service_id','user_id','comment', 'approved', 'admin_comment','date_time','rate','rate_comment','done'];
    protected $casts = ['date_time'  => 'date:Y-m-d H:i',];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }

}
