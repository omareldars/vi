<?php

namespace App\Http\Controllers;

use App\Service;
use App\ServiceCategory;
use App\Http\Requests\StoreServiceCategoryRequest;
use App\Http\Requests\UpdateServiceCategoryRequest;

use DB;
use Log;
use Exception;
use Session;

class ServiceCategoryController extends Controller
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

            $user =  $this->preProcessingCheck('view_service_category');
            $serviceCategories = ServiceCategory::all();
            return view('admin/settings/service_categories/index', compact('serviceCategories'));

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

            $user =  $this->preProcessingCheck('add_service_category');
            return view('admin/settings/service_categories/create');

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
    public function store(StoreServiceCategoryRequest $request)
    {
        try{

            $user =  $this->preProcessingCheck('add_service_category');
            $result = ServiceCategory::create($request->all());

            if($result)
                return redirect()->route('serviceCategories.index')->with( ['msg' => 'StoredSuccessfully'] );
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
     * @param  \App\ServiceCategory  $ServiceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceCategory $ServiceCategory)
    {
        $user =  $this->preProcessingCheck('view_service_category');
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceCategory  $ServiceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        try{
            $user =  $this->preProcessingCheck('edit_service_category');
            return view('admin/settings/service_categories/edit', compact('serviceCategory'));

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
     * @param  \App\ServiceCategory  $ServiceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $serviceCategory)
    {

        try{

            $user =  $this->preProcessingCheck('edit_service_category');
            $result = $serviceCategory->update($request->all());

            if($result)
                return redirect()->route('serviceCategories.index')->with( ['msg' => 'aStoredSuccessfully'] );
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
     * @param  \App\ServiceCategory  $ServiceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        try{
            $user =  $this->preProcessingCheck('delete_service_category');

            Service::where('service_category_id', $serviceCategory->id)->delete();
            $serviceCategory->delete();

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
