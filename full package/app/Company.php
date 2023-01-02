<?php

namespace App;

use App\Like;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Auditable;
    protected $fillable = ['state_id', 'city_id', 'name_en', 'name_ar', 'address_en', 'sector', 'address_ar', 'phone', 'fax', 'email', 'website',
        'est_date','idea','problem','solution','team_num', 'stage','raised_fund','investors','founder','employees','facebook', 'twitter',
        'linkedin', 'youtube', 'google_map', 'logo','cycle','step','approved','approved_by'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function stepdata()
    {
        return $this->belongsTo(Step::class,'step');
    }
    public function cycledata()
    {
        return $this->belongsTo(Cycle::class,'cycle');
    }
    public function companyWeight($c,$f,$u)
    {
        $weight = Formdata::where('company_id',$c)->where('form_id',$f)->pluck("screening");
        $total = $j = 0;
        if(count($weight)>0) {
            if ($u>0) {
                foreach ($weight as $item) {if (isset($item[$u])) {
                    $total = $item[$u] + $total;
                }}
                $weight = $total/count($weight)*10;
            } else {
                foreach ($weight as $item) {
                    if($item){
                    $j=count($item);
                    foreach($item as $key => $value){$total = $total+ $value;}}}
                $weight=$total/count($weight)*10;
                if ($j>1){$weight = $weight/$j;}
            }
        } else {$weight=0;}
        return ((int)$weight);
    }
    public function companyJudge($c,$f,$u)
    {
        $weight = Formdata::where('company_id',$c)->where('form_id',$f)->pluck("screening");
        $all = count($weight);$count = 0;
        if($weight)
        {foreach ($weight as $item)
        if(isset($item[$u])){
        {if($item[$u]){$count++;}}}}
        if($all == 0){return (0);}
        return ((int)$count/$all*100);
    }
    public function judges($c,$f)
    {
        $list = Formdata::where('company_id',$c)->where('form_id',$f)->pluck("screening")->first();
        $judges = [];
        if ($list) {
            foreach($list as $key => $value ){$judges[] = $key ;}
        }
        return $judges;
    }
    public function finals($s)
    {
        $list = Finalscreening::where('company_id',$this->id)->where('step_id',$s)->pluck("judges")->first();
        $judges = [];
        if ($list) {
            foreach($list as $key => $value ){$judges[] = $value ;}
        }
        return $judges;
    }
    public function fsession($s)
    {
        return (Finalscreening::where('company_id',$this->id)->where('step_id',$s)->first());
    }
}
