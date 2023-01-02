<?php
namespace App\Http\Controllers;
use App\Company;
use App\CyclesMentors;
use App\Events\WebMessage;
use App\Messages;
use App\User;
use Illuminate\Http\Request;
use App\Messenger;
use App\Notifications\TemplateEmail;
use Auth;

class MessengerController extends Controller
{
	public function index() {
	$received = Messenger::leftJoin('users','sender','=','users.id')
                ->where('receiver',Auth::user()->id)
                ->orderBy('created_at','DESC')->get(['messenger.id','first_name_en','last_name_en','first_name_ar',
                'last_name_ar','subject','read','messenger.created_at','messenger.sender']);
	return view('admin.clients.inbox')->with('received',$received);
	}
    public function outbox() {
        $sent = Messenger::leftJoin('users','receiver','=','users.id')
            ->where('sender',Auth::user()->id)->orderBy('created_at','DESC')->get(['messenger.id','first_name_en','last_name_en','first_name_ar',
                'last_name_ar','subject','read','messenger.receiver','messenger.created_at']);
        return view('admin.clients.outbox')->with('sent',$sent);
    }
    public function openmsg(Request $request) {
	    if ($request->type==1) {
        $getmsg = Messenger::leftJoin('users','sender','=','users.id')->where('receiver',Auth::user()->id)->where('messenger.id',$request->id)->first(['messenger.id','first_name_en','last_name_en','first_name_ar',
                'last_name_ar','subject','message','read','messenger.sender','messenger.created_at']);
        if(!$getmsg) {return response()->json('error');}
        $getmsg->read = 1;
        $getmsg->Save();
        } else {
        $getmsg = Messenger::leftJoin('users','receiver','=','users.id')->where('sender',Auth::user()->id)->where('messenger.id',$request->id)->first(['messenger.id','first_name_en','last_name_en','first_name_ar',
                'last_name_ar','subject','message','read','messenger.receiver','messenger.created_at']);
            if(!$getmsg) {return response()->json('error');}
        }
        return response()->json($getmsg);
    }
	public function sendmsg(Request $request){
        try{
		    $new = new Messenger();
            $new->sender = $request->input('sender');
			$new->receiver = $request->input('receiver');
            $new->messgeId = $request->input('messgeId');
            $new->subject= $request->input('subject');
			$new->message = $request->input('message');
            $new->Save();
            $rname = User::findOrFail($request->input('receiver'));
            $sname =  User::findOrFail($request->input('sender'));
            /// notify user vi push
            /// event(new WebMessage('NewMsg', $rname->first_name_en.' '.$rname->last_name_en, $request->input('receiver')));
            /// Send Mail
            $user = new User();
            $user->email = $rname->email;
            $user->id = $rname->id;
            $rfullname = $rname->first_name_en ." ". $rname->last_name_en;
            $sfullname = $sname->first_name_en ." ". $sname->last_name_en;
            $MSG = new TemplateEmail;
            $MSG->Message=["New message received - VI portal","Dear ".$rfullname.",","You have a new message from ".$sfullname.', Needs your review.',"/admin/inbox"];
            $user->notify($MSG);
            /// End of send

		return redirect()->back()->with('message','Done');
			} catch (Exception $e){
            //log what happend//
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
	}

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');
            $del = Messenger::where('sender', Auth::user()->id)->where('id', $id)->first();
           if ($del){
                Messenger::Destroy($id);
                return response()->json([
                    'state' => 'success'
                ], 200);
            } else {
                 return response()->json([
                     'state' => 'unauthorized'
                 ], 401);
             }
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            return response()->json([
                'state' => 'failed'
            ], 500);

        }
    }
    public function sendmessage() {
       	$users = $mentors = null;
	    if (Auth::user()->hasanyRole('Admin|Manager')) {
	        $users = Company::get();
	        $mentors = User::join('model_has_roles', 'id', 'model_id')->where('role_id', 6)->get();
        } elseif (Auth::user()->hasRole('Mentor')) {
	        $cycles = CyclesMentors::where('user_id',Auth::id())->get(['cycle_id'])->toArray();
            $users = Company::whereIn('cycle',array_values($cycles))->get();
            $mentors = null;
        } elseif (Auth::user()->company) {
          if(Auth::user()->company->approved) {
            $users = Company::where('cycle',Auth::user()->company->cycle)->where('id','!=',Auth::user()->company->id)->get();
            $mentors = User::join('cycles_mentors', 'users.id', 'user_id')->where('cycle_id',Auth::user()->company->cycle)->get(['users.id','first_name_ar','first_name_en','last_name_ar','last_name_en']);}
        } 
        return view('admin/clients/sendmessage', compact('users','mentors'));
    }
    public function savemessage(Request $request) {
        $cuser = Auth::user();
	    if ($request->type==1) {
            if (!$request->users) { return redirect('/admin')->with(['msg' => 'MessageError', 'class' => 'danger']);}
            foreach ($request->users as $key=>$rec) {
                $new = new Messenger();
                $new->sender = $cuser->id;
                $new->receiver = $rec;
                $new->subject= $request->input('subject');
                $new->message = $request->input('message');
                $new->Save();
                $rname = User::findOrFail($rec);
                /// Send Mail
                $user = new User();
                $user->email = $rname->email;
                $user->id = $rname->id;
                $rfullname = $rname->first_name_en ." ". $rname->last_name_en;
                $sfullname = $cuser->first_name_en ." ". $cuser->last_name_en;
                $MSG = new TemplateEmail;
                $MSG->Message=["New message received - VI portal","Dear ".$rfullname.",","You have a new message from ".$sfullname.', Needs your review.',"/admin/inbox"];
                $user->notify($MSG);
                /// End of send
            }
        } elseif ($request->type==2) {
            if (!$request->mentors) { return redirect('/admin')->with(['msg' => 'MessageError', 'class' => 'danger']);}
            foreach ($request->mentors as $key=>$rec) {
                $new = new Messenger();
                $new->sender = $cuser->id;
                $new->receiver = $rec;
                $new->subject = $request->input('subject');
                $new->message = $request->input('message');
                $new->Save();
                $rname = User::findOrFail($rec);
                /// Send Mail
                $user = new User();
                $user->email = $rname->email;
                $user->id = $rname->id;
                $rfullname = $rname->first_name_en . " " . $rname->last_name_en;
                $sfullname = $cuser->first_name_en . " " . $cuser->last_name_en;
                $MSG = new TemplateEmail;
                $MSG->Message = ["New message received - VI portal", "Dear " . $rfullname . ",", "You have a new message from " . $sfullname . ', Needs your review.', "/admin/inbox"];
                $user->notify($MSG);
                /// End of send
            }
        } else {
            $new = new Messages();
            $name = $cuser->first_name_en.' '.$cuser->last_name_en;
            $new->name = $name;
            $new->internal_id = $cuser->id;
            $new->phone = $cuser->phone;
            $new->email = $cuser->email;
            $new->subject = $request->input('subject');
            $new->message = $request->input('message');
            $new->userip = $request->getClientIp();
            $new->Save();
            event(new WebMessage('mymsg', $name));
        }
        return redirect('/admin')->with(['msg' => 'MessageSent', 'class' => 'success']);
    }


}
