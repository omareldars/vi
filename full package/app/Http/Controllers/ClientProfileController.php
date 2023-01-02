<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdateClientProfileRequest;
use App\Http\Requests\UpdateClientProfilePasswordRequest;
use App\UsersBio;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Hash;
use DB;
use Auth;
use Log;
use Exception;
use Session;

class ClientProfileController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $Type
     * @return \Illuminate\Http\Response
     */
    public function edit(){
        try{
            $client = Auth::user();
            return view('admin/clients/profile', compact('client'));
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $Type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientProfileRequest $request)
    {
        try{
            $user = Auth::user();
            //add bio
            if ($request->bio_ar || $request->bio_en){
                UsersBio::updateOrInsert(['user_id'=>$user->id],['bio_ar'=>$request->bio_ar, 'bio_en'=>$request->bio_en,'specialization_ar'=>$request->specialization_ar,'specialization_en'=>$request->specialization_en,'linkedIn'=>$request->linkedin]);
            }
            if ($request->hasFile('img_url')) {
                //store the image
                $img_url = $request->file('img_url');
                //get the path of the stores image
                $img_url = $img_url->store('users', ['disk' => 'public_uploads']);
                //resize
                Image::make(Storage::disk('public_uploads')->path($img_url))->resize(null, 200, function($con) {$con->aspectRatio();})->save();
                //update
                $result = $user->update($request->except(['img_url','password']) + ['img_url' => $img_url]);


            }else{
                $result = $user->update($request->except(['password']));
            }
            if($result)
                return redirect()->route('my_profile')->with( ['msg' => 'StoredSuccessfully', 'class' => 'success'] );
            else
                return back()->withInput()->with( ['msg' => 'FailedStore', 'class' => 'danger'] );
        }catch (Exception $e) {
            //log what happend
            dd($e);
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $Type
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdateClientProfilePasswordRequest $request)
    {
        try{
            $user = Auth::user();
            $password = Hash::make($request->password);
            $result = $user->where('id', $user->id)
                            ->update(['password' => $password]);
            if($result)
                return redirect()->route('my_profile')->with( ['msg' => 'StoredSuccessfully', 'class' => 'success'] );
            else
                return back()->withInput()->with( ['msg' => 'FailedStore', 'class' => 'danger'] );
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }
}
