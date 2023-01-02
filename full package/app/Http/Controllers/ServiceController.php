<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

use App\Notifications\TemplateEmail;
use App\Service;
use App\ServiceCategory;

use App\ServicesRequests;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Exception;
use Session;

class ServiceController extends Controller
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
    public function index()
    {
        try{

            $user =  $this->preProcessingCheck('view_service');
            $services = Service::with('serviceCategory')->get();
            return view('admin/settings/services/index', compact('services'));

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

            $user =  $this->preProcessingCheck('add_service');
            $serviceCategories = ServiceCategory::all();
            return view('admin/settings/services/create', compact('serviceCategories'));

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
    public function store(StoreServiceRequest $request)
    {
        try{

            $user =  $this->preProcessingCheck('add_service');

            if ($request->hasFile('img_url')) {
                 //store the image
                $img_url = $request->file('img_url');
                //get the path of the stores image
                $img_url = $img_url->store('services', ['disk' => 'public_uploads']);

            }else{
                $img_url = '';
            }

            $result = Service::create($request->except(['img_url']) + ['img_url' => $img_url]);

            if($result)
                return redirect()->route('services.index')->with( ['msg' => 'StoredSuccessfully'] );
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
     * @param  \App\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $Service)
    {
        $user =  $this->preProcessingCheck('view_service');
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        try{

            $user =  $this->preProcessingCheck('edit_service');
            $serviceCategories = ServiceCategory::all();
            return view('admin/settings/services/edit', compact('service', 'serviceCategories'));

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
     * @param  \App\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        try{

            $user =  $this->preProcessingCheck('edit_service');

            if ($request->hasFile('img_url')) {
                //store the image
               $img_url = $request->file('img_url');
               //get the path of the stores image
               $img_url = $img_url->store('services', ['disk' => 'public_uploads']);
               //update
               $result = $service->update($request->except(['img_url']) + ['img_url' => $img_url]);

            }else{
                $result = $service->update($request->all());
            }


            if($result)
                return redirect()->route('services.index')->with( ['msg' => 'StoredSuccessfully'] );
            else
                return back()->withInput()->with( ['msg' => 'FailedStore'] );

        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        try{
            $user =  $this->preProcessingCheck('delete_service');
            $service->delete();
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
    public function requests(){
        $received = ServicesRequests::whereNull('approved')->get();
        $countold = ServicesRequests::whereNotNull('approved')->count();
        return view('admin.settings.services.requests', compact('received','countold') );
    }
    public function oldrequests(){
        $received = ServicesRequests::whereNotNull('approved')->get();
        return view('admin.settings.services.oldrequests', compact('received') );
    }
    public function approve(Request $request){
        if ($request) {
        ServicesRequests::where('id', $request->id)->update(['approved'=>$request->stat,'admin_comment'=>$request->comment,'admin'=>Auth::id()]);
            /// notify user via Mail
                    $crequest = ServicesRequests::findOrfail($request->id);
                    $request->stat=="Yes" ? $stat = "approved" : $stat = "disapproved";
                    $user = new User();
                    $user->email = $crequest->user->email;
                    $user->id = $crequest->user_id;
                    $rfullname = $crequest->user->first_name_en ." ". $crequest->user->last_name_en;
                    $MSG = new TemplateEmail;
                    $MSG->Message=["Service request - VI portal","Dear ".$rfullname.",", "Kindly note that your service request (".$crequest->service->name_en . ") has been ".$stat.", Check your account for more details.","/admin/requests/mine"];
                    $user->notify($MSG);
            /// End of mail send
        return response()->json(['state'=>'success']);
        }
        return response()->json([
            'state' => 'failed'
        ], 500);
    }
    public function myrequests(){
        $received = ServicesRequests::join('services','service_id','services.id')->where('user_id',Auth::id())->orderBy('services_requests.created_at','DESC')
            ->get(['services_requests.id as id','services.id as sid','services.name_en as title_en','services.name_ar as title_ar', 'services_requests.comment'
                , 'services_requests.approved','services_requests.admin_comment','services_requests.created_at']);
        return view('admin.clients.myrequests', compact('received') );
    }
}
