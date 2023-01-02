<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DB;
use Log;
use Exception;

use Spatie\Permission\Models\Permission;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * A function to check the user and its permissions.
     *
     * @return 401 or the User.
     */
    public function preProcessingCheck($permissionName){
        
        try{

            if(env('APP_ENV') == 'local')
                app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            $permission = DB::table('permissions')->where('name', $permissionName)->first();
            if(!$permission)
                abort(401);
            $user = auth()->user();
            if(!$user)
                abort(401);
            if (!$user->hasPermissionTo($permissionName))
                abort(401);
            return $user;
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
 
            abort(401);
 
        }
    }


    /**
     *	return APi request result
     *	if failed or successed
     */
	protected function returnApiResult($code, $status, $message, $dataContent){
       
        try{
            $response['meta'] = [
                'code' => $code,
                'status' => $status,
                'message' => $message,
            ];
            $response['data'] = $dataContent;
            
            return response()->json($response, $code, [], JSON_UNESCAPED_UNICODE);
            
        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);

            abort(401);

        }
    }


    /**
     * A function to return a JSON response in case of Model not found error
     */
    protected function validationErrorsResponse($validation_errors){
        try{    
            //build the response
            $code = 400; //Bad Request: missing or invalid data
            $status = 'errors';
            $message = "Validation Errors";
            $dataContent = $validation_errors;

            return $this->returnApiResult($code, $status, $message, $dataContent);
        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);

            abort(401);

        }
    }

    /**
     * A function to return a JSON response in case of unknown error message happend
     */
    protected function unknownErrorHappenedMsg(){
        
        try{
            $code = 503; //Service Unavailable
            $status = 'errors';
            $message = "Unknown error happened, please try again later";
            $dataContent = '';
            
            return $this->returnApiResult($code, $status, $message, $dataContent);

        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);

            abort(401);

        }
    }
}
