<?php

 namespace App\Http\Controllers;
 use App\Events\WebMessage;
 use Illuminate\Http\Request;
 use Validator,Redirect,Response,File;
 use Socialite;
 use App\User;
 use Illuminate\Support\Str;
 use Illuminate\Support\Facades\Hash;

 class SocialController extends Controller
 {

    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider){
        $getInfo = Socialite::driver($provider)->user();
        $user = $this->createUser($getInfo,$provider);
      if ($user == [1]) {
      return redirect()->to('/login')->withErrors(['social'=>'error']);
      }
      	auth()->login($user);
        return redirect()->to('/admin');
    }

    function createUser($getInfo,$provider){
        $user = User::where('provider_id', $getInfo->id)->first();
      	if (!$user) {
        $user = User::where('email', $getInfo->email)->first();
          if ($user){return $user = [1];}
        			}
        if (!$user) {
          	$name = explode(" ",$getInfo->name);
            $user = User::create([
                'first_name_en' => $name[0],
              	'last_name_en' => $name[1],
                'email'    => $getInfo->email,
              	'password' => Hash::make('no need for password token based'),
                'provider' => $provider,
                'provider_id' => $getInfo->id,
              	'email_verified_at' => now()
            ]);
          $user->assignRole('Registered');
          event(new WebMessage('NewUser', $getInfo->name, 1));
        }
        return $user;
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback(){

        try {

            $guser = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $guser->id)->first();
			if (!$finduser) {
          $finduser = User::where('email', $guser->email)->first();
          if ($finduser){
          return redirect()->to('/login')->withErrors(['social'=>'error']);
          }
        			}
            if($finduser){
              	auth()->login($finduser);
                return redirect('/admin');
            }else{
                $name = explode(" ",$guser->name);
                $newUser = User::create([
                  	'first_name_en'     => $name[0],
              		'last_name_en' => $name[1],
                    'email' => $guser->email,
                    'password' => Hash::make('no need for password token based'),
                    'google_id'=> $guser->id,
					'email_verified_at' => now()
                ]);
				$newUser->assignRole('Registered');
                event(new WebMessage('NewUser', $guser->name, 1));
              	auth()->login($newUser);
                return redirect()->back();
            }

        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }
 }
