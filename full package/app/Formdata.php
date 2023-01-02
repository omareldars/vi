<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formdata extends Model
{
    protected $fillable = ['field_id', 'company_id', 'user_id', 'form_id','step_id', 'question', 'answer', 'screening', 'comments'];
    protected $table ='form_data';
    protected $primaryKey = ['field_id', 'company_id'];
    public $incrementing = false;
    protected $casts = [
        'screening' => 'array',
        'comments' => 'array',
    ];
    public function company()
    {
        return Company::where('id',$this->company_id)->first(['name_ar','name_en']);
    }
}
