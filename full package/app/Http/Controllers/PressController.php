<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePressRequest;
use App\Http\Requests\UpdatePressRequest;
use App\Press;
use DB;
use Log;
use Exception;
use Session;

class PressController extends Controller
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
            $user =  $this->preProcessingCheck('view_press');
            $press = Press::all();
            return view('admin/settings/press/index', compact('press'));

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

            $user =  $this->preProcessingCheck('add_press');
            $press = Press::all();
            return view('admin/settings/press/create', compact('press'));

        }catch (Exception $e){dd($e);

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
    public function store(StorepressRequest $request)
    {
        try{

            $user =  $this->preProcessingCheck('add_press');

            if ($request->hasFile('img_url')) {
                //store the image
                $img_url = $request->file('img_url');
                //get the path of the stores image
                $img_url = $img_url->store('press', ['disk' => 'public_uploads']);
            }else{
                $img_url = '';
            }
            $user =auth()->user()->id;
            $result = Press::create($request->except(['img_url','user_added']) + ['img_url' => $img_url,'user_added' => $user]);

            if($result)
                return redirect()->route('press.index')->with( ['msg' => 'StoredSuccessfully'] );
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
     * @param  \App\press  press
     * @return \Illuminate\Http\Response
     */
    public function show(Press $press)
    {
        $user =  $this->preProcessingCheck('view_press');
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\press  $press
     * @return \Illuminate\Http\Response
     */
    public function edit(Press $press)
    {
        try{

            $user =  $this->preProcessingCheck('edit_press');
            return view('admin/settings/press/edit', compact('press'));

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
     * @param  \App\press  $press
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePressRequest $request, Press $press)
    {
        try{

            $user =  $this->preProcessingCheck('edit_press');
            $user =auth()->user()->id;
            if ($request->hasFile('img_url')) {
                //store the image
                $img_url = $request->file('img_url');
                //get the path of the stores image
                $img_url = $img_url->store('press', ['disk' => 'public_uploads']);
                //update

                $result = $press->update($request->except(['img_url','user_added']) + ['img_url' => $img_url,'user_added'=>$user]);

            }else{
                $result = $press->update($request->except(['user_added'])+ ['user_added'=>$user]);
            }

            if($result)
                return redirect()->route('press.index')->with( ['msg' => __('StoredSuccessfully')] );
            else
                return back()->withInput()->with( ['msg' => 'FailedStore'] );

        }catch (Exception $e){
dd($e);
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\press  $press
     * @return \Illuminate\Http\Response
     */
    public function destroy(Press $press)
    {
        try{

            $user =  $this->preProcessingCheck('delete_press');
            $press->delete();
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
