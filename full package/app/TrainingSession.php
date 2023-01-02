<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use Auditable;
    protected $table = 'training_sessions';
    protected $fillable = ['step_id', 'title', 'dsc', 'datetime', 'duration', 'zoom_id', 'start_url', 'join_url'];
    protected $casts = ['datetime'  => 'date:Y-m-d H:i',];

    public function step() {
        return $this->belongsTo(Step::class);
    }
}
