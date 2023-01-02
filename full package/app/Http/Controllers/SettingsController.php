<?php
namespace App\Http\Controllers;
use App\Calendar;
use App\Cycle;
use App\MentorshipRequest;
use App\Notifications\TemplateEmail;
Use App\Settings;
Use App\Messages;
use App\TrainingSession;
use App\User;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
use App\Event;
use Illuminate\Support\Facades\Notification;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function get_settings(Request $request){
            $this->preProcessingCheck('edit_settings');
			$Title = Settings::findOrfail('1');
			$Icons = Settings::where('type','2')->get();
			$Img1 =  Settings::findOrfail('7');
			$Img2 =  Settings::findOrfail('8');
			$Img3 =  Settings::findOrfail('9');
			$Counters = Settings::where('type','6')->get();
            return view('admin.settings.editegeneral')
                ->with('Title',$Title)->with('Icons',$Icons)->with('Img1',$Img1)
				->with('Img2',$Img2)->with('Img3',$Img3)->with('Counters',$Counters);
    }
    public function update_settings(Request $request){
            $this->preProcessingCheck('edit_settings');
			$Title = Settings::findOrfail('1');
			$Icon1 = Settings::findOrfail('2');
			$Icon2 = Settings::findOrfail('3');
			$Icon3 = Settings::findOrfail('4');
			$Icon4 = Settings::findOrfail('5');
			$Icon5 = Settings::findOrfail('6');
			$Img1 =  Settings::findOrfail('7');
			$Img2 =  Settings::findOrfail('8');
			$Img3 =  Settings::findOrfail('9');
			$counter1 = Settings::findOrfail('12');
            $counter2 = Settings::findOrfail('13');
            $counter3 = Settings::findOrfail('14');
            $counter4 = Settings::findOrfail('15');

			$Title->title = $request->input('site_title');
            $Title->ar_title = $request->input('site_ar_title');
            $request->input('autoact')=='on'?$Title->set_order = 1:$Title->set_order = null;
            $Title->url = $request->input('gtag');
			$Title->Save();
 			$Icon1->url = $request->input('facebook');
			$Icon1->Save();
 			$Icon2->url = $request->input('twitter');
			$Icon2->Save();
			$Icon3->url = $request->input('youtube');
			$Icon3->Save();
			$Icon4->url = $request->input('instagram');
			$Icon4->Save();
			$Icon5->url = $request->input('linkedin');
			$Icon5->Save();
			/// Img 1
						if($request->file('img1')){
if(in_array($request->file('img1')->getClientMimeType(),["image/png","image/jpeg","image/gif"]))
		{
            $file = $request->file('img1');
            $path = 'images/resource/';
            $fileExtension = $request->file('img1')->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::random(5).\Illuminate\Support\Str::limit(Carbon::today().Carbon::now(),10,'i1');
            $filename2 =$filename.'.'.$fileExtension;
            $file->move($path, $filename.'.'.$fileExtension);
			$Img1->img_url = $filename2 ;
		}}
			$Img1->title = $request->input('img1title');
			$Img1->ar_title = $request->input('ar_img1title');
			$Img1->set1 = $request->input('img1title2');
			$Img1->ar_set1 = $request->input('ar_img1title2');
			$Img1->dsc = $request->input('img1dsc');
			$Img1->ar_dsc = $request->input('ar_img1dsc');
			$Img1->url = $request->input('img1url');
			$Img1->Save();
			/// Img 2
						if($request->file('img2')){
if(in_array($request->file('img2')->getClientMimeType(),["image/png","image/jpeg","image/gif"]))
		{
            $file = $request->file('img2');
            $path = 'images/resource/';
            $fileExtension = $request->file('img2')->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::random(5).\Illuminate\Support\Str::limit(Carbon::today().Carbon::now(),10,'i2');
            $filename2 =$filename.'.'.$fileExtension;
            $file->move($path, $filename.'.'.$fileExtension);
			$Img2->img_url = $filename2 ;
		}}
			$Img2->title = $request->input('img2title');
			$Img2->ar_title = $request->input('ar_img2title');
			$Img2->set1 = $request->input('img2title2');
			$Img2->ar_set1 = $request->input('ar_img2title2');
			$Img2->dsc = $request->input('img2dsc');
			$Img2->ar_dsc = $request->input('ar_img2dsc');
			$Img2->url = $request->input('img2url');
			$Img2->Save();
		/// Img 3
						if($request->file('img3')){
if(in_array($request->file('img3')->getClientMimeType(),["image/png","image/jpeg","image/gif"]))
		{
            $file = $request->file('img3');
            $path = 'images/resource/';
            $fileExtension = $request->file('img3')->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::random(5).\Illuminate\Support\Str::limit(Carbon::today().Carbon::now(),10,'i3');
            $filename2 =$filename.'.'.$fileExtension;
            $file->move($path, $filename.'.'.$fileExtension);
			$Img3->img_url = $filename2 ;
		}}
			$Img3->title = $request->input('img3title');
			$Img3->ar_title = $request->input('ar_img3title');
			$Img3->set1 = $request->input('img3title2');
			$Img3->ar_set1 = $request->input('ar_img3title2');
			$Img3->dsc = $request->input('img3dsc');
			$Img3->ar_dsc = $request->input('ar_img3dsc');
			$Img3->url = $request->input('img3url');
			$Img3->Save();

			/// Save Counters
            $counter1->title = $request->input('ct12title');
            $counter1->ar_title = $request->input('ct12titlear');
            $counter1->dsc = $request->input('ct12num');
            $counter1->img_url = $request->input('ct12icon');
            $counter1->Save();
            $counter2->title = $request->input('ct13title');
            $counter2->ar_title = $request->input('ct13titlear');
            $counter2->dsc = $request->input('ct13num');
            $counter2->img_url = $request->input('ct13icon');
            $counter2->Save();
            $counter3->title = $request->input('ct14title');
            $counter3->ar_title = $request->input('ct14titlear');
            $counter3->dsc = $request->input('ct14num');
            $counter3->img_url = $request->input('ct14icon');
            $counter3->Save();
            $counter4->title = $request->input('ct15title');
            $counter4->ar_title = $request->input('ct15titlear');
            $counter4->dsc = $request->input('ct15num');
            $counter4->img_url = $request->input('ct15icon');
            $counter4->Save();

            return redirect()->back()->with('message', 'StoredSuccessfully');
    }
public function get_aboutus(Request $request){
            $this->preProcessingCheck('edit_settings');
			$allabout = Settings::findorfail('10');
            return view('admin.settings.editaboutus')->with('allabout',$allabout);
    }
public function update_aboutus(Request $request){
            $this->preProcessingCheck('edit_settings');
			$allabout = Settings::findorfail('10');
			$allabout->title = $request->input('title');
			$allabout->ar_title = $request->input('ar_title');
			$allabout->dsc = $request->input('dsc');
			$allabout->ar_dsc = $request->input('ar_dsc');
			$allabout->set1 = $request->input('set1');
			$allabout->ar_set1 = $request->input('ar_set1');
			$allabout->set2 = $request->input('set2');
			$allabout->ar_set2 = $request->input('ar_set2');
			$allabout->url = $request->input('url');
			$allabout->Save();
            return redirect('admin/setaboutus')->with('message', 'StoredSuccessfully');
    }
public function get_contactus(Request $request){
            $this->preProcessingCheck('edit_settings');
			$allcontact = Settings::findorfail('11');
            return view('admin.settings.editcontactus')->with('allcontact',$allcontact);
    }
public function update_contactus(Request $request){
            $this->preProcessingCheck('edit_settings');
			$allcontact = Settings::findorfail('11');
			$allcontact->title = $request->input('title');
			$allcontact->ar_title = $request->input('ar_title');
			$allcontact->dsc = $request->input('dsc');
			$allcontact->ar_dsc = $request->input('ar_dsc');
			$allcontact->set1 = $request->input('set1');
			$allcontact->ar_set1 = $request->input('ar_set1');
			$allcontact->set2 = $request->input('set2');
			$allcontact->ar_set2 = $request->input('ar_set2');
			$allcontact->Save();
            return redirect('admin/setcontactus')->with('message', 'StoredSuccessfully');
    }
    //// Contact US Messages
    public function mymsg(){
            $this->preProcessingCheck('view_messages');
			$getmsgs = messages::orderBy('read')->orderBy('created_at','DESC')->get(['id','name','email','subject','read','internal_id','replyBy']);
            return view('admin.settings.messages')
                ->with('getmsgs',$getmsgs);
    }
    //// Send reply via mail
    public function msgreply(Request $request){
        $this->preProcessingCheck('view_messages');
        /// Send Mail
        $Email = $request->remail;
        if ($Email == filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $rfullname = $request->rname;
            $MSG = new TemplateEmail;
            $MSG->Message = [$request->subject.' - VI portal', "Dear " . $rfullname . ",", $request->message, "/admin"];
            Notification::route('mail', $Email)->notify($MSG);
            Messages::find($request->mid)->update([
                'reSubject' => $request->subject,
                'reMessage' => $request->message,
                'replyBy' => Auth::user()->id,
            ]);
            return redirect()->back()->with(['msg' => 'MessageSent', 'class' => 'success']);
        }
        /// End of send
        return redirect()->back()->with(['msg' => 'MessageError', 'class' => 'danger']);
    }
    public function openonemsg($id){
        $this->preProcessingCheck('view_messages');
        $getmsg = messages::findOrFail($id);
        $getmsg->read = 1;
        $getmsg->user_id = Auth::user()->id;
        $getmsg->Save();
        $user=[];
        if ($getmsg->replyBy) {$user = User::where('id',$getmsg->replyBy)->first(['first_name_ar','last_name_ar','first_name_en','last_name_en']);}
        return response()->json([$getmsg,$user]);
    }
		public function deletemsg($id){
            $this->preProcessingCheck('delete_messages');
            $read = messages::findOrfail($id);
            $read->user_id = Auth::user()->id;
            $read->Save();
            $read->delete();
            return redirect('admin/mymsg')->with('message', 'DeletedSuccessfully');
    }
			public function makeread($id){
            $this->preProcessingCheck('view_messages');
			$read = messages::findOrfail($id);
			$read->read = 1;
			$read->user_id = Auth::user()->id;
			$read->Save();
            return redirect()->back();
    }
            public function makeunread($id){
            $this->preProcessingCheck('view_messages');
            $read = messages::findOrfail($id);
            $read->user_id = Auth::user()->id;
            $read->read = 0;
            $read->Save();
            return redirect()->back();
    }
public function calendar(Request $request){
    if($request->ajax()) {
        /// my data
        $step = '';
        if(Auth::user()->company) {$step = Auth::user()->company->step;}
        $data = Calendar::where('user_id',Auth::user()->id)->where(function($query) use($request) {
            $query->orwhereDate('start', '>=', $request->start)
                ->orwhereDate('end', '<=', $request->end);
        })->get(['id', 'title', 'start', 'end', 'color', 'calendarId','allDay', DB::raw('"true" AS editable')]);
        $mentors = MentorshipRequest::where('user_id',Auth::id())->where('approved','Yes')->where(function($query) use($request) {
            $query->orwhereDate('zoom_date', '>=', $request->start)
                ->orwhereDate('zoom_date', '<=', $request->end);})->get([DB::raw('2000000+`id` as id,"#000" AS color,"s" AS calendarId, `zoom_date` AS start ," جلسة إرشاد Online session" AS title')]);
        $sessions = TrainingSession::where('step_id',$step)->orderBy('datetime','ASC')->where(function($query) use($request) {
            $query->orwhereDate('datetime', '>=', $request->start)
                ->orwhereDate('datetime', '<=', $request->end);})->get([DB::raw('3000000+`id` as id,"#157230" AS color,"t" AS calendarId, `datetime` AS start ,`title` AS title')]);
        $events = Event::where('published',1)->where(function($query) use($request){
            $query->orwhereDate('timerdate', '>=', $request->start)
                ->orwhereDate('timerdate',   '<=', $request->end);
        })->get(['id', 'title_en AS title', 'timerdate AS start',DB::raw('"#607d8b" AS color, "e" AS calendarId')]);
        if (Auth::user()->can('edit_calendar')) {
            $public = Calendar::whereNull('isPrivate')->where(function($query) use($request) {
                $query->orwhereDate('start', '>=', $request->start)
                    ->orwhereDate('end', '<=', $request->end);
            })->get(['id', 'title', 'start', 'end', 'color', 'calendarId','allDay', DB::raw('"true" AS editable')]);
        } else {
            $public = Calendar::whereNull('isPrivate')->where(function($query) use($request) {
                $query->orwhereDate('start', '>=', $request->start)
                    ->orwhereDate('end', '<=', $request->end);
            })->get(['id', 'title', 'start', 'end', 'color', 'calendarId','allDay',DB::raw('"p" AS calendarId')]);
        }
        $data = $data->merge($public)->merge($events)->merge($mentors)->merge($sessions);
        return response()->json($data);
                        }
    return view('admin.calendar');
    }
    public function editcal($id)
    {
        if (Auth::user()->can('edit_calendar')) {
            $cal = Calendar::findOrFail($id);
        } else {
            $cal = Calendar::where('user_id',Auth::user()->id)->findOrFail($id);
        }
        return view('admin.calendaredit', compact( 'cal'));
    }
    public function updatecal(Request $request, $id)
    {
        $private = 1;
        if (Auth::user()->can('edit_calendar')) {$private=$request->isPrivate?1:null;}
        Calendar::find($id)->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'body' => $request->body,
            'color' => $request->color,
            'allDay' => $request->allDay?1:null,
            'isPrivate' => $private,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('calendar');
    }
    public function delcal($id)
    {
        if (Auth::user()->can('edit_calendar')) {
        Calendar::find($id)->delete(); } else {
        Calendar::where('user_id',Auth::user()->id)->find($id)->delete();
        }
        return redirect()->route('calendar');
    }
    public function ajax(Request $request)
    {

        switch ($request->type) {
            case 'add':
                $event = Calendar::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'allDay' => $request->allDay,
                    'user_id' => Auth::user()->id,
                    'isPrivate' =>1,
                ]);
                return response()->json($event);
                break;
            case 'update':
                $event = Calendar::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'allDay' => $request->allDay,
                    'user_id' => Auth::user()->id,
                ]);
                return response()->json($event);
                break;
        }
    }
    public function viewcal(Request $request) {
        if ($request->id) {
            $event = Calendar::findOrFail($request->id);
            return response()->json($event);
        }
        return response()->json([
            'state' => 'failed'
        ], 500);
    }
}
