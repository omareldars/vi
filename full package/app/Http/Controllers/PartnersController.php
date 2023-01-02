<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Partner;
use DB;
use Log;
use Exception;
use Session;


class PartnersController extends Controller
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
            $this->preProcessingCheck('view_partner');
            $partners = Partner::all();
            return view('admin/settings/partners/index', compact('partners'));

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
            $user =  $this->preProcessingCheck('add_partner');
            $partner = Partner::all();
            return view('admin/settings/partners/create', compact('partner'));
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
    public function store(StorepartnerRequest $request)
    {
        try{
            $user =  $this->preProcessingCheck('add_partner');
            if ($request->hasFile('img_url')) {
                //store the image
                $img_url = $request->file('img_url');
                //get the path of the stores image
                $img_url = $img_url->store('partners', ['disk' => 'public_uploads']);
            }else{
                $img_url = '';
            }
            $user =auth()->user()->id;
            $result = Partner::create($request->except(['img_url','user_added']) + ['img_url' => $img_url,'user_added' => $user]);

            if($result)
                return redirect()->route('partners.index')->with( ['msg' => 'StoredSuccessfully'] );
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
     * @param  \App\partner  partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        $user =  $this->preProcessingCheck('view_partner');
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        try{

            $user =  $this->preProcessingCheck('edit_partner');
            return view('admin/settings/partners/edit', compact('partner'));

        }catch (Exception $e) {
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        try{

            $user =  $this->preProcessingCheck('edit_partner');
            $user =auth()->user()->id;
            if ($request->hasFile('img_url')) {
                //store the image
                $img_url = $request->file('img_url');
                //get the path of the stores image
                $img_url = $img_url->store('partners', ['disk' => 'public_uploads']);
                //update

                $result = $partner->update($request->except(['img_url','user_added']) + ['img_url' => $img_url,'user_added'=>$user]);

            }else{
                $result = $partner->update($request->except(['user_added'])+ ['user_added'=>$user]);
            }

            if($result)
                return redirect()->route('partners.index')->with( ['msg' => __('StoredSuccessfully')] );
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
     * @param  \App\partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        try{
            $user =  $this->preProcessingCheck('delete_partner');
            $partner->delete();
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
}
