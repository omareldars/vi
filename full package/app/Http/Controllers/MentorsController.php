<?php

namespace App\Http\Controllers;

use App\Company;
use App\Cycle;
use App\CyclesMentors;
use App\Events\WebMessage;
use App\MentorshipRequest;
use App\Schedule;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ZoomMeetingTrait;
use Illuminate\Support\Facades\DB;
use App\Notifications\TemplateEmail;

class MentorsController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;
  
    public function index($id = 0)
    {
        $this->preProcessingCheck('edit_cycles');
        if($id==0){$id = Cycle::orderBy('start','DESC')->pluck('id')->first();}
        $companies = Company::where('cycle',$id)->where('step','>',0)->get();
        $mentors = CyclesMentors::where('cycle_id',$id)->get();
        return view('admin.settings.mentorship.index', compact( 'mentors','id','companies'));
    }
    public function list($id = 0){
        $this->preProcessingCheck('edit_cycles');
        if($id==0){$id = Cycle::orderBy('start','DESC')->pluck('id')->first();}
        $mentors = User::join('model_has_roles', 'id', 'model_id')->where('role_id', 6)->get();
        $clist = CyclesMentors::where('cycle_id',$id)->pluck('user_id')->toArray();
        return view('admin.settings.mentorship.assign', compact( 'mentors','id','clist'));
    }
    public function assign($id ,Request $request){
        $this->preProcessingCheck('edit_cycles');
        if ($request->id){
            CyclesMentors::where('cycle_id',$request->id)->delete();
            if ($request->users) {
            foreach ($request->users as $user) {
                CyclesMentors::insert(['cycle_id'=>$request->id,'user_id'=>$user]);
            }}
        }
        return back();
    }
    public function addwait(Request $request)
    {
        if ($request->mentorid) {
            if ($request->date < date("Y-m-d 00:00:00")) {return back()->with(['msg' => "Error, can't add late date.",'class'=>'danger']);}
            // uploadfile
            $fileName ='';
            if ($request->hasFile('file_url')) {
                $fileName = $request->file('file_url');
                $fileName = $fileName->store(Auth::id(), ['disk' => 'PrivateDisk']);
            }
            MentorshipRequest::insert(['mentor_id' => $request->mentorid, 'user_id' => Auth::id(), 'comment' => $request->notes,
                'zoom_date' => $request->date, 'period' => $request->period, 'fileurl' => $fileName]);
            // Notify Admin here
            event(new WebMessage('NewMent', Auth::user()->first_name_en .' '. Auth::user()->last_name_en));
            return back()->with(['msg' => 'Request successfully added','class'=>'success']);
        } else {
            return back()->with(['msg' => "Error, can't add request",'class'=>'danger']);
        }
    }
    public function add(Request $request)
    {
        $this->preProcessingCheck('edit_cycles');
        if ($request->userid) {
           	$topic = "Online mentorship meeting (M" . $request->mentorid . '- U'.$request->userid . ')';
          	$data = ['topic'=>$topic, "start_time"=>$request->date, 'duration'=>$request->period, 'host_video'=>1, 'participant_video'=>1];
          	$zoom = $this->create($data);
          	if (!$zoom['success']) {return back()->with(['message2' => "Error, can't create zoom meeting."]);}
            MentorshipRequest::insert(['mentor_id' => $request->mentorid, 'user_id' => $request->userid, 'admin_comment' => $request->notes, 'approved' => 'Yes',
                'admin_id' => Auth::id(), 'start_url' => $zoom['data']['start_url'], 'join_url' => $zoom['data']['join_url'], 'zoom_date' => $request->date, 'period' => $request->period]);
            /// notify user via Mail
            /// Notify Mentor
                    $rname = User::findOrFail($request->mentorid);
                    $rname_usr = User::findOrFail($request->userid);
                    $user = new User();
                    $user->email = $rname->email;
                    $user->id = $rname->id;
                    $rfullname = $rname->first_name_en ." ". $rname->last_name_en;
                    $rfullname_usr = $rname_usr->first_name_en ." ". $rname_usr->last_name_en;
                    $MSG = new TemplateEmail;
                    $MSG->Message=["New Mentorship session - VI portal","Dear ".$rfullname.",","Kindly note you have a new mentorship session with '".$rfullname_usr."', Session will start:".$request->date.
                        ", Check your account to join the session ","/admin"];
                    $user->notify($MSG);
            /// Notify User
                    $user = new User();
                    $user->email = $rname_usr->email;
                    $user->id = $rname_usr->id;
                    $MSG = new TemplateEmail;
                    $MSG->Message=["New Mentorship session - VI portal","Dear ".$rfullname_usr.",","Kindly note you have a new mentorship session with '".$rfullname."', Session will start:".$request->date.
                        ", Check your account to join the session ","/admin"];
                    $user->notify($MSG);
            /// End of mail send
            return back()->with(['message' => 'Session successfully added']);
        } else{
            return back()->with(['message2' => "Error, can't add session"]);
        }
    }
    public function sessions(Request $request)
    {
        $this->preProcessingCheck('edit_cycles');
        if ($request->show == 'all') {
            $sessions = MentorshipRequest::get();
        } elseif ($request->show == 'approved')  {
            $sessions = MentorshipRequest::whereNotNull('start_url')->get();
        } else {
            $sessions = MentorshipRequest::whereNull('approved')->get();
        }
        return view('admin.settings.mentorship.sessions', compact( 'sessions'));
    }
  	public function getsession(Request $request) {
      if ($request){
       $my = MentorshipRequest::findOrFail($request->id);
       return response()->json($my);
      } else {
       return response()->json(['state' => 'failed'], 500); 
      }
    }
  	public function modifysession(Request $request) {
      if ($request){
      $approved = $start = $join = null;
      if ($request->approved) {
        $approved ='Yes';
        $topic = "Online mentorship meeting (M" . $request->mentorid . '- U'.$request->userid . ')';
        $data = ['topic'=>$topic, "start_time"=>$request->date, 'duration'=>$request->period, 'host_video'=>1, 'participant_video'=>1];
        $zoom = $this->create($data);
      if (!$zoom['success']) {return back()->with(['message2' => "Error, can't create zoom meeting."]);}
       	$start = $zoom['data']['start_url'];
        $join = $zoom['data']['join_url'];   
      }
      MentorshipRequest::where('id',$request->id)->update(['period'=> $request->period, 'zoom_date'=>$request->date, 'admin_comment' => $request->notes, 'approved'=>$approved, 'start_url' => $start, 'join_url' => $join ]);
          /// Notify Mentor
          $session = MentorshipRequest::findOrFail($request->id);
          $rname = User::findOrFail($session->mentor_id);
          $rname_usr = User::findOrFail($session->user_id);
          $user = new User();
          $user->email = $rname->email;
          $user->id = $rname->id;
          $rfullname = $rname->first_name_en ." ". $rname->last_name_en;
          $rfullname_usr = $rname_usr->first_name_en ." ". $rname_usr->last_name_en;
          $MSG = new TemplateEmail;
          $MSG->Message=["New Mentorship session - VI portal","Dear ".$rfullname.",","Kindly note you have a new mentorship session with '".$rfullname_usr."', Session will start:".$request->date.
              ", Check your account to join the session ","/admin"];
          $user->notify($MSG);
          /// Notify User
          $user = new User();
          $user->email = $rname_usr->email;
          $user->id = $rname_usr->id;
          $MSG = new TemplateEmail;
          $MSG->Message=["New Mentorship session - VI portal","Dear ".$rfullname_usr.",","Kindly note you have a new mentorship session with '".$rfullname."', Session will start:".$request->date.
              ", Check your account to join the session ","/admin"];
          $user->notify($MSG);
          /// End of mail send
      return back()->with(['message' => 'ٍaved successfully']);
      } else {return back()->with(['message2' => 'Error saving data']);}
    }

    public function modify(Request $request)
    {
       // $this->preProcessingCheck('edit_mentorship'); /// modify permissions
            try {
                $type = $request->rtype;
                if ($type == 6) {
                  	$start = $join = null;
                  	   if($request->stat=='Yes'){
                  	$mrequest = MentorshipRequest::findOrFail($request->id);
                  	$topic = "Online mentorship meeting (M" . $mrequest->mentor_id . '- U'.$mrequest->user_id . ')';
          			$data = ['topic'=>$topic, "start_time"=>$mrequest->zoom_date, 'duration'=>$mrequest->period, 'host_video'=>1, 'participant_video'=>1];
          			$zoom = $this->create($data);
                       if (!$zoom['success']) {return response()->json('failed, zoom api error');}
                    $start = $zoom['data']['start_url'];
                    $join = $zoom['data']['join_url'];  
                    }
                    MentorshipRequest::where('id',$request->id)->update(['approved'=>$request->stat, 'start_url' => $start, 'join_url' => $join ]);
                    /// Notify Mentor
                    $session = MentorshipRequest::findOrFail($request->id);
                    $rname = User::findOrFail($session->mentor_id);
                    $rname_usr = User::findOrFail($session->user_id);
                    $user = new User();
                    $user->email = $rname->email;
                    $user->id = $rname->id;
                    $rfullname = $rname->first_name_en ." ". $rname->last_name_en;
                    $rfullname_usr = $rname_usr->first_name_en ." ". $rname_usr->last_name_en;
                    $MSG = new TemplateEmail;
                    $MSG->Message=["New Mentorship session - VI portal","Dear ".$rfullname.",","Kindly note you have a new mentorship session with '".$rfullname_usr."', Session will start:".$request->date.
                        ", Check your account to join the session ","/admin"];
                    $user->notify($MSG);
                    /// Notify User
                    $user = new User();
                    $user->email = $rname_usr->email;
                    $user->id = $rname_usr->id;
                    $MSG = new TemplateEmail;
                    $MSG->Message=["New Mentorship session - VI portal","Dear ".$rfullname_usr.",","Kindly note you have a new mentorship session with '".$rfullname."', Session will start:".$request->date.
                        ", Check your account to join the session ","/admin"];
                    $user->notify($MSG);
                    /// End of mail send
                    return response()->json('success');
                } elseif ($type == 5) {
                    $my = Schedule::where('active',1)->where('user_id', $request->id)->get();
                    $sessions = MentorshipRequest::where('mentor_id',$request->id)->where('zoom_date','>=',date("Y-m-d 00:00:00"))->where('approved','Yes')
                        ->get(['zoom_date as dfrom','period AS tfrom',DB::raw("(id + 1000000) AS id, 'Session' AS type, 'Mentorship session' AS notes")]);
                    $my = $my->merge($sessions);
                    return response()->json($my);
                } elseif ($type == 4) {
                    $values = ['type' => $request->type, 'days' => json_encode($request->days), 'dfrom' => $request->dfrom, 'dto' => $request->dto, 'tfrom' => $request->tfrom, 'tto' => $request->tto, 'notes' => $request->notes];
                    Schedule::where('user_id', Auth::id())->where('id', $request->id)->update($values);
                    return back()->with(['msg' => 'Saved', 'class' => 'success']);
                } elseif ($type == 3) {
                    Schedule::where('user_id', Auth::id())->where('id', $request->id)->delete();
                    return response()->json(['state' => 'success']);
                } elseif ($type == 2) {
                    $stat = $request->stat ? 0 : 1;
                    Schedule::where('user_id', Auth::id())->where('id', $request->id)->update(['active' => $stat]);
                    return response()->json(['state' => 'success']);
                } elseif ($type == 1) {
                    $my = Schedule::where('user_id', Auth::id())->where('id', $request->id)->first();
                    return response()->json($my);
                } else {
                    Schedule::create($request->all() + ['user_id' => Auth::id()]);
                    return back()->with(['msg' => 'Saved', 'class' => 'success']);
                }
            } catch (Exception $e) {
                return response()->json(['state' => 'failed'], 500);
            }
    }
    public function mine() {
        $sessions = MentorshipRequest::where('user_id',Auth::id())->orderBy('zoom_date','DESC')->get();
        return view('admin.clients.mymentorships', compact( 'sessions'));
    }
    public function rate(Request $request){
        if($request) {
            $request->done?$done=1:$done=null;
            MentorshipRequest::where('id',$request->id)->where('user_id',Auth::id())->update(['rating'=>$request->rate,'rate_comment'=>$request->comment,'done'=>$done]);
            return back();
        }else {
            return back();
        }
    }
}