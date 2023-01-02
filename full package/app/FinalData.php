<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinalData extends Model
{
    protected $table = "final_data";
    protected $fillable = ['field_id','judge_id','company_id','step_id','question','answer'];

    public function judge()
    {
        return $this->belongsTo(User::class,'judge_id','id');
    }
}