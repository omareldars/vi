<?php

namespace App\Http\Controllers;

use App\Step;
use App\Training;
use App\TrainingCompleted;
use App\TrainingContent;
use App\TrainingSession;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\Traits\ZoomMeetingTrait;

class TrainingController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;


    public function all($id=0) {
        $this->preProcessingCheck('edit_cycles');
        $courses = Training::orderBy('created_at','DESC')->get();
        if ($id==0 && count($courses)) {
            $id = $courses->pluck('id')[0];
        }
        $contents = TrainingContent::where('training_id',$id)->orderBy('arr','ASC')->get();
        return view('admin/settings/training/all', compact('courses','id','contents'));
    }
    public function edit($id) {
        $this->preProcessingCheck('edit_cycles');
        $courses = Training::findOrFail($id);
        return response()->json($courses);
    }
    public function store(Request $request) {
        $this->preProcessingCheck('edit_cycles');
        if ($request->hasFile('image')) {
            $img_url = $request->file('image');
            $img_url = $img_url->store('training', ['disk' => 'public_uploads']);
            Image::make(Storage::disk('public_uploads')->path($img_url))->resize(null, 350, function($con) {$con->aspectRatio();})->save();
            Training::updateOrCreate(['id'=>$request->id],['title'=>$request->title,'dsc'=>$request->dsc,'user_id'=>Auth::id(),'image'=>$img_url]);
        } else {
            Training::updateOrCreate(['id'=>$request->id],['title'=>$request->title,'dsc'=>$request->dsc,'user_id'=>Auth::id()]);
        }
        return back()->with(['class'=>'success','message'=>'Saved']);
    }

    public function delete($id, Request $request){
        $this->preProcessingCheck('edit_cycles');
        if ($request) {
         Training::where('id',$id)->delete();
         TrainingContent::where('training_id',$id)->delete();
         return response()->json(['state' => 'success']);
            } else {
         return response()->json(['state' => 'failed'], 500);
        }
    }

    public function addcontent($id) {
        $this->preProcessingCheck('edit_cycles');
        $check = Training::findOrFail($id);
        $arr = TrainingContent::where('training_id',$id)->orderBy('arr','ASC')->get(['title','arr']);
        if (count($arr)==0) {$arr=[];}
        if($check) {
            return view('admin/settings/training/add_content', compact('id','arr'));
        } else {
            return back()->with(['class'=>'danger','message'=>'must add training course first.']);
        }
    }

    public function editcontent($id) {
        $this->preProcessingCheck('edit_cycles');
        $content = TrainingContent::findOrFail($id);
        $arr = TrainingContent::where('training_id',$content->training_id)->orderBy('arr','ASC')->get(['title','arr']);
        if($content) {
            return view('admin/settings/training/edit_content', compact('content','id','arr'));
        } else {
            return back()->with(['class'=>'danger','message'=>'Error, content not exist.']);
        }
    }
    public function viewcontent($id) {
        $this->preProcessingCheck('edit_cycles');
        $content = TrainingContent::findOrFail($id);
        if($content) {
            return view('admin/settings/training/view_content', compact('content'));
        } else {
            return back()->with(['class'=>'danger','message'=>'Error, content not exist.']);
        }
    }

    public function storecontent(Request $request) {
        $this->preProcessingCheck('edit_cycles');
        if ($request->tcontent) {
            $id = $request->id ?? null;
            $arr = $i = 1;
            if ($request->arr) {
                $arr = $request->arr;
                $old = TrainingContent::where('training_id',$request->training_id)->orderBy('arr','ASC')->get();
                foreach ($old as $item) {
                    if($item->arr == $arr){$i++;}
                    TrainingContent::where('id',$item->id)->update(['arr'=>$i++]);
                }
            }
            TrainingContent::updateOrCreate(['id'=>$id],['title'=>$request->title,'content'=>$request->tcontent,'training_id'=>$request->training_id,'user_id'=>Auth::id(),'arr'=>$arr]);
            return redirect('/admin/training/all/'. $request->training_id)->with(['class'=>'success','message'=>'Saved']);
        }
        return back()->withInput()->with(['class'=>'danger','message'=>'Error']);
    }

    public function delcontent($id, Request $request){
        $this->preProcessingCheck('edit_cycles');
        if ($request) {
            $removedid = TrainingContent::where('id',$id)->first(['training_id'])->training_id;
            TrainingContent::where('id',$id)->delete();
            /// Rearrange
            $old = TrainingContent::where('training_id',$removedid)->orderBy('arr','ASC')->get();
            foreach ($old as $key=>$item) {
                    TrainingContent::where('id',$item->id)->update(['arr'=>$key+1]);
                }
            return response()->json(['state' => 'success'], 200);
        } else {
            return response()->json(['state' => 'failed'], 500);
        }
    }
    public function upload(Request $request) {
        $this->preProcessingCheck('edit_cycles');
        $fileName = $request->file('file');
        $fileName = $fileName->store('photos', ['disk' => 'TrainingDisk']);
        return response()->json(['location'=> '/admin/training/'.$fileName]); //env('APP_URL'). full URL
    }
    public function my($id,Request $request) {
            $step = Auth::user()->company->step;
            $tr = Step::findOrfail($step);
            $c = $request->c ?? 0;
            if ($tr->stype == 4) {
            $contents = TrainingContent::where('training_id',$id)->orderBy('arr')->get(['id','title','training_id']);
            if ($c==0){$ccontent = TrainingContent::where('training_id',$id)->orderBy('arr','ASC')->first(['id','content']);} else {
                $ccontent = TrainingContent::where('training_id',$id)->where('id',$c)->first(['id','title','content']);
            }
            if(!$contents) {return back()->with(['class'=>'danger','message'=>'Error, content not exist.']);}
                /// save progress
                TrainingCompleted::updateOrInsert(['training_id'=>$ccontent->id,'user_id'=>Auth::id()],['course_id'=>$id]);
                return view('admin/clients/training', compact('contents','ccontent'));
            } else {
                return back()->with(['class'=>'danger','message'=>'ErrorNoPermissions']);
            }
    }
    public function results($id = 0)
    {
        $this->preProcessingCheck('edit_cycles');
        $sessions = TrainingSession::where('type','online')->orderBy('datetime')->get();
        if ($id == 0) {
            $id = $sessions->pluck('id')->first();
            $csession = TrainingSession::where('type','online')->where('id', $id)->first();
        } else {
            $csession = TrainingSession::where('type','online')->where('id', $id)->first();
        }
        $contents = 0;
        if ($csession) {
            $contents = TrainingContent::where('training_id', $csession->location)->count();
        }
        return view('admin.settings.training.results', compact('csession', 'sessions', 'id', 'contents'));
    }
    public function sessions($id=0) {
        $this->preProcessingCheck('edit_cycles');
        $steps = Step::where('stype',4)->get();
        if ($id == 0) {$id = $steps->pluck('id')->first();}
        $sessions = TrainingSession::where('step_id',$id)->orderBy('datetime','ASC')->get();
        $online = Training::get();
        return view('admin/settings/training/sessions', compact('steps','id','sessions','online'));
    }
    public function mysessions() {
      	$sessions = [];
      	if (Auth::user()->company){
        $sessions = TrainingSession::where('step_id',Auth::user()->company->step)->orderBy('datetime','ASC')->get();
        }
        return view('admin/settings/training/mysessions', compact('sessions'));
    }
    public function addsession(Request $request) {
        $this->preProcessingCheck('edit_cycles');
        $step = $request->step_id;
        $title = $request->title;
        $dsc = $request->dsc;
        $datetime = $request->datetime;
        $type =$request->type;
        if ($type=='sessions') {
          // Add Zoom
            $topic = "Training (" . $title . ')';
            $data = ['topic'=>$topic, "start_time"=>$datetime, 'duration'=>$request->duration, 'host_video'=>1, 'participant_video'=>1];
            $zoom = $this->create($data);
            if (!$zoom['success']) {return back()->with(['message'=>'Can\'t create zoom meeting, API error','class' => 'danger']);}
            $zoomid =  $zoom['data']['id'];
            $start = $zoom['data']['start_url'];
            $join = $zoom['data']['join_url'];
            TrainingSession::insert(['type'=>$type,'step_id'=>$step,'title'=>$title,'dsc'=>$dsc,'zoom_id'=>$zoomid,'datetime'=>$datetime,
                'duration'=>$request->duration,'user_id'=>Auth::id(),'start_url'=>$start,'join_url'=>$join,'trainer_name'=>$request->trainer_name]);
            return back()->with(['message'=>'Session added successfully','class' => 'success']);
        } elseif ($type=='online') {
            if(!$request->online) {return back()->with(['message2','Can\'t add training you must add new training course first']);}
            TrainingSession::insert(['type'=>$type,'step_id'=>$step,'title'=>$title,'dsc'=>$dsc,'datetime'=>$datetime,'user_id'=>Auth::id(),'location'=>$request->online]);
            return back()->with(['message'=>'Saved','class' => 'success']);
        } elseif ($type=='offline') {
            TrainingSession::insert(['type'=>$type,'step_id'=>$step,'title'=>$title,'dsc'=>$dsc,'datetime'=>$datetime,'user_id'=>Auth::id(),'location'=>$request->location,
                'enddatetime'=>$request->enddatetime, 'trainer_name'=>$request->trainer_name]);
            return back()->with(['message'=>'Saved','class' => 'success']);
        } else {
            return back()->with(['message'=>'Can\'t add session','class' => 'danger']);
        }
    }

    public function editsession(Request $request) {
        $this->preProcessingCheck('edit_cycles');
        $title = $request->title;
        $dsc = $request->dsc;
        $datetime = $request->datetime;
        $type =$request->stype;
        $id = $request->sid;
        if ($type=='sessions') {
            // Add Zoom
            $topic = "Training (" . $title . ')';
            $data = ['topic'=>$topic, "start_time"=>$datetime, 'duration'=>$request->duration, 'host_video'=>1, 'participant_video'=>1];
            $zoom = $this->create($data);
            if (!$zoom['success']) {return back()->with(['message'=>'Can\'t create zoom meeting, API error','class' => 'danger']);}
            $zoomid =  $zoom['data']['id'];
            $start = $zoom['data']['start_url'];
            $join = $zoom['data']['join_url'];
            TrainingSession::where('id',$id)->update(['type'=>$type,'title'=>$title,'dsc'=>$dsc,'zoom_id'=>$zoomid,'datetime'=>$datetime,
                'duration'=>$request->duration,'user_id'=>Auth::id(),'start_url'=>$start,'join_url'=>$join,'trainer_name'=>$request->trainer_name]);
            return back()->with(['message'=>'Session added successfully','class' => 'success']);
        } elseif ($type=='online') {
            if(!$request->online) {return back()->with(['message2','Can\'t add training you must add new training course first']);}
            TrainingSession::where('id',$id)->update(['type'=>$type,'title'=>$title,'dsc'=>$dsc,'datetime'=>$datetime,'user_id'=>Auth::id(),'location'=>$request->online]);
            return back()->with(['message'=>'Saved','class' => 'success']);
        } elseif ($type=='offline') {
            TrainingSession::where('id',$id)->update(['type'=>$type,'title'=>$title,'dsc'=>$dsc,'datetime'=>$datetime,'user_id'=>Auth::id(),'location'=>$request->location,
                'enddatetime'=>$request->enddatetime, 'trainer_name'=>$request->trainer_name]);
            return back()->with(['message'=>'Saved','class' => 'success']);
        } else {
            return back()->with(['message'=>'Can\'t edit session','class' => 'danger']);
        }
    }
    public function session(Request $request) {
        $this->preProcessingCheck('edit_cycles');
      if ($request->id) {
            $session = TrainingSession::findOrFail($request->id);
            return response()->json($session);
      }  else {
            return response()->json(['state' => 'failed'], 500);
      }
    }
    public function delsession($id, Request $request){
        $this->preProcessingCheck('edit_cycles');
        $zoomid = TrainingSession::findOrFail($id)->zoom_id;
        if($request) {
            if ($zoomid) {
                $zoom = $this->delete($zoomid);
                if (!$zoom['success']) {
                    return response()->json(['state' => 'failed'], 500);
                }
            }
            TrainingSession::findOrFail($id)->delete();
            return response()->json(['state' => 'success'], 200);
        } else {
            return response()->json(['state' => 'failed'], 500);
        }
    }
    public function getdsc($id) {
        if($id) {
            $session = TrainingSession::findOrFail($id);
            return response()->json($session);
        } else {
            return response()->json(['state' => 'failed'], 500);
        }
    }
}