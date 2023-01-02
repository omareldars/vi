<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;   /// New by ibrahim.suez
use App\Traits\Auditable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Auditable;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name_en', 'last_name_en', 'first_name_ar', 'last_name_ar','gender', 'phone', 'email', 'title_ar', 'title_en', 'HaveCompany', 'company_id', 'state_id', 'city_id', 'password', 'provider', 'provider_id', 'google_id','email_verified_at','img_url',
        'PageId','dob','academic_stat','university','faculty','employer','expertise'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //// New
	public function sendPasswordResetNotification($token)
	{
    	$this->notify(new ResetPasswordNotification($token));
	}
    public function sendEmailVerificationNotification()
    {
    $this->notify(new Notifications\VerifyEmailQueued);
	}
	/// By Ibrahim Elsayed
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function calendar() {
        return $this->hasMany(Calendar::class);
    }
    public function mentorship() {
        return $this->hasMany(MentorshipRequest::class);
    }
    public function bio() {
        return $this->hasOne(UsersBio::class);
    }
    public function mrating(){
        return (MentorshipRequest::where('mentor_id',$this->id)->avg('rating'));
    }
}