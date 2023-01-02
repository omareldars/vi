<?php

namespace App\Http\Controllers;
use App\Events\WebMessage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateClientCompanyRequest;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\State;
use App\City;
use App\Company;
use App\Like;
use DB;
use Auth;
use Log;
use Exception;
use Session;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ClientCompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function show($id)
    {
        try{
            $company = Company::with('state')
                                ->with('city')
                                ->with('user')
                                ->findorfail($id);
            return view('admin/clients/company_profile', compact('company'));
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }
    /**
     * Show the form for editing/Createing the specified resource.
     *
     * @param  \App\Company  $Type
     * @return \Illuminate\Http\Response
     */
    public function editOrCreate(){
        try{
            $client = User::with('company')
                         //   ->with('company.services:id')
                            ->with('company.city')
                            ->find(Auth::id());
            $states = State::all();
            $cities = City::all();
            return view('admin/clients/company', compact('client', 'states', 'cities'));
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            dd($e);
            abort(500);
        }
    }
    /**
     * Update/Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrStore(StoreUpdateClientCompanyRequest $request)
    {
        try{
            $user = Auth::user();
            $companyId = $user->company_id;
            if ($request->hasFile('img_url')) {
                $img_url = $request->file('img_url');
                //get the path of the stores image
                $img_url = $img_url->store('users', ['disk' => 'public_uploads']);
                //resize
                Image::make(Storage::disk('public_uploads')->path($img_url))->resize(null, 200, function($con) {$con->aspectRatio();})->save();
                $result = Company::updateOrCreate(
                    ['id' => $companyId],
                    $request->all() + ['logo' => $img_url]
                );
            } else {
                $result = Company::updateOrCreate(['id' => $companyId], $request->all());
            }

                $msgtype = 'UpdateComp';
            if(!$companyId) {
                User::where('id', Auth::id())->update(['company_id' => $result->id]);
                $msgtype = 'NewComp';
            }
            if($result) {
                event(new WebMessage($msgtype, $user->first_name_en,'1'));
                return redirect()->route('my_company')->with(['msg' => 'StoredSuccessfully', 'class' => 'success']);
            }
            else {
                return back()->withInput()->with(['msg' => 'FailedStore', 'class' => 'danger']);
                }
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            dd($e);
            abort(500);
        }
    }
     /**
     * Update/Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function likeService(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'company_id' => 'required|numeric',
                'service_id' => 'required|numeric',
                'current_state' => 'required',
                'rate' => 'numeric',
            ]);
            if ($validator->fails())
                return $this->validationErrorsResponse($validator->errors());
            $user = Auth::user()->id;
            $current_state = $request->current_state;
            $company_id = $request->company_id;
            $service_id = $request->service_id;
            if($current_state == 'unliked'){ //Like
                $result = Like::updateOrCreate(
                        $request->only(['company_id','service_id']) + ['user_id' => $user],
                        $request->all() + ['user_id' => $user]
                    );
            }elseif($current_state == 'liked'){ //Unlike
                Like::where('company_id', $company_id)
                        ->where('service_id', $service_id)
                        ->where('user_id', $user)
                        ->delete();
            }
            //build the response
            $code = 200; //successful Request:
            $status = 'success';
            $message = "The data has been Deleted successfully";
            $dataContent = ['row_id'=> $result->id];
            if($result)
                return $this->returnApiResult($code, $status, $message, $dataContent);
            else
                return $this->unknownErrorHappenedMsg();
        }catch (Exception $e){ dd($e);
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }
}
