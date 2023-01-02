<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;

use App\Type;

use DB;
use Log;
use Exception;
use Session;


class TypeController extends Controller
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

            $user =  $this->preProcessingCheck('view_type');
            $types = Type::all();
            return view('admin/settings/types/index', compact('types'));

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

            $user =  $this->preProcessingCheck('add_type');
            return view('admin/settings/types/create');

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
    public function store(StoreTypeRequest $request)
    {
        try{

            $user =  $this->preProcessingCheck('add_type');
            $result = Type::create($request->all());

            if($result)
                return redirect()->route('types.index')->with( ['msg' => __('StoredSuccessfully')] );
            else
                return back()->withInput()->with( ['msg' => __('FailedStore')] );

        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Type  $Type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $Type)
    {
        $user =  $this->preProcessingCheck('view_type');
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $Type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        try{

            $user =  $this->preProcessingCheck('edit_type');
            return view('admin/settings/types/edit', compact('type'));

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
    public function update(UpdateTypeRequest $request, Type $type)
    {
        try{

            $user =  $this->preProcessingCheck('edit_type');
            $result = $type->update($request->all());

            if($result)
                return redirect()->route('types.index')->with( ['msg' => __('StoredSuccessfully')] );
            else
                return back()->withInput()->with( ['msg' => __('FailedStore')] );

        }catch (Exception $e){dd($e);

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $Type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        try{

            $user =  $this->preProcessingCheck('delete_type');

            $type->delete();

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
