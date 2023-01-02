<?php
namespace App\Http\Controllers;
use App\EventsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Event;
use Carbon\Carbon;
use Redirect;

class EventsController extends Controller
{
    public function add_event(){
        try{
        if (!Auth::user()->hasAnyPermission(['manage_events'])) {return abort(401);}
            return view('admin.settings.events.add_new_event');
            }catch (Exception $e){
            //log what happend
        Log::channel('system_exceptions')->info('Exceptions:', [$e]);
        abort(500);
        }
    }
    public function store_event(Request $request)
    {
        try{
        if (!Auth::user()->hasAnyPermission(['manage_events'])) {return abort(401);}
			$filename2 = null;
if($request->file('image'))
if(in_array($request->file('image')->getClientMimeType(),["image/png","image/jpeg","image/gif"]))
		{{
            $file = $request->file('image');
            $path = 'images/resource/';
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::random(5).\Illuminate\Support\Str::limit(Carbon::today().Carbon::now(),10);
            $filename2 =$filename.'.'.$fileExtension;
            $file->move($path, $filename.'.'.$fileExtension);

		}}
        if($request->input('showtimer') =='on') {$showtimer=1;} else {$showtimer=null;}
        if($request->input('published') =='on') {$published=1;} else {$published=null;}
            $newevent = new Event();
			$newevent->image = $filename2;
            $newevent->title_en = $request->input('title_en');
            $newevent->title_ar = $request->input('title_ar');
			$newevent->body_ar = $request->input('body_ar');
            $newevent->body_en = $request->input('body_en');
			$newevent->showtimer = $showtimer;
			$newevent->timerdate = $request->input('timerdate');
			$newevent->googlemap = $request->input('googlemap');
			$newevent->published = $published;
            $newevent->user_id = Auth::user()->id;
            $newevent->Save();
            return redirect('admin/allevents')->with('message','StoredSuccessfully');
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }
    public function myEvent(){
        if (!Auth::user()->hasAnyPermission(['manage_events'])) {return abort(401);}
        {
            $getevents = Event::orderBy('created_at','ASC')->get();
        }
        return view('admin.settings.events.events')
            ->with('getevents',$getevents);
    }
    public function editevent($id,Request $request){
            if (!Auth::user()->hasAnyPermission(['manage_events'])) {return abort(401);}
            $getevents = Event::findOrfail($id);
            return view('admin.settings.events.edit_event')
                ->with('getevents',$getevents);
    }
    public function updateevent($id,Request $request){
        if (!Auth::user()->hasAnyPermission(['manage_events'])) {return abort(401);}
			$updateevent = Event::findOrfail($id);
	if($request->file('image')){
	if(in_array($request->file('image')->getClientMimeType(),["image/png","image/jpeg","image/gif"])){
            $file = $request->file('image');
            $path = 'images/resource/';
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::random(20).\Illuminate\Support\Str::limit(Carbon::today().Carbon::now(),10,'event');
            $filename2 =$filename.'.'.$fileExtension;
            $file->move($path, $filename.'.'.$fileExtension);
 			$updateevent->image = $filename2;
			}}
        if($request->input('showtimer') =='on') {$showtimer=1;} else {$showtimer=null;}
        if($request->input('published') =='on') {$published=1;} else {$published=null;}
            $updateevent->title_ar = $request->input('title_ar');
            $updateevent->title_en = $request->input('title_en');
			$updateevent->body_ar = $request->input('body_ar');
            $updateevent->body_en = $request->input('body_en');
			$updateevent->showtimer = $showtimer;
			$updateevent->timerdate = $request->input('timerdate');
			$updateevent->googlemap = $request->input('googlemap');
			$updateevent->published = $published;
            $updateevent->user_id = Auth::user()->id;
            $updateevent->Save();
         return redirect('admin/allevents')->with('message','StoredSuccessfully');
    }
    public function deleteevent($id)
    {
        if (!Auth::user()->hasAnyPermission(['manage_events'])) {return abort(401);}
            Event::Destroy($id);
            EventsUser::where('event_id',$id)->delete();
            return redirect()->back()->with('message', 'DeletedSuccessfully');
    }
}
