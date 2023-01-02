<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role as Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;

use App\User;

use DB;
use Log;
use Exception;
use Session;
use Hash;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        try{

            $this->preProcessingCheck('view_user');
            $users = User::with('company')->with('roles')->get();
            return view('admin/users/index', compact('users'));

        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{

            $this->preProcessingCheck('add_user');
            $roles = Role::all();
            return view('admin/users/create', compact('roles'));

        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try{

            $this->preProcessingCheck('add_user');

            if ($request->hasFile('img_url')) {
                 //store the image
                $img_url = $request->file('img_url');
                //get the path of the stores image
                $img_url = $img_url->store('users', ['disk' => 'public_uploads']);
            }else{
                $img_url = '';
            }
            $result = User::create($request->except(['img_url']) + ['img_url' => $img_url]);

            $result->assignRole($request->role);

            if($result)
                return redirect()->route('users.index')->with( ['msg' => 'StoredSuccessfully'] );
            else
                return back()->withInput()->with( ['msg' => 'FailedStore'] );

        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->preProcessingCheck('view_user');
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        try{

            $this->preProcessingCheck('edit_user');
            $roles = Role::all();
            return view('admin/users/edit', compact('user', 'roles'));

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
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try{

            $this->preProcessingCheck('edit_user');
            if ($user->id==1){return back()->with( ['msg' => 'FailedStore'] );}
            if ($request->hasFile('img_url')) {
                //store the image
               $img_url = $request->file('img_url');
               //get the path of the stores image
               $img_url = $img_url->store('services', ['disk' => 'public_uploads']);
               //update
                $result = $user->update($request->except(['img_url']) + ['img_url' => $img_url]);

            }else{
                $result = $user->update($request->all());
            }

            $user->roles()->detach();
            $user->assignRole($request->role);

            if($result)
                return redirect()->route('users.index')->with( ['msg' => 'StoredSuccessfully'] );
            else
                return back()->withInput()->with( ['msg' => 'FailedStore'] );

        }catch (Exception $e){dd($e);

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        try{
            if ($request->id==1){return back()->with( ['msg' => 'FailedStore', 'class' => 'danger']  );}
            $this->preProcessingCheck('edit_user');

            $user = User::find($request->id);
            $password = Hash::make($request->password);
            $result = $user->where('id', $user->id)
                            ->update(['password' => $password]);

            if($result)
                return redirect()->route('users.index')->with( ['msg' => 'StoredSuccessfully', 'class' => 'success'] );
            else
                return back()->withInput()->with( ['msg' => 'FailedStore', 'class' => 'danger'] );

        }catch (Exception $e){dd($e);

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id==1){return response()->json([
            'state' => 'failed'
        ], 500);}
        try{
            $this->preProcessingCheck('delete_user');
            $user->roles()->detach();
            $user->delete();
            $user->company()->delete();
            return response()->json([
                'state' => 'success'
            ], 200);

        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            return response()->json([
                'state' => 'failed'
            ], 500);

        }
    }

    public function companies () {
        $this->preProcessingCheck('view_user');
        $companies = Company::get();
        return view('admin/users/companies')->with('companies',$companies);
    }
}
