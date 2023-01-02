<?php

namespace App\Http\Controllers;

use App\Company;
use App\Formdata;
use App\Formfield;
use App\Notifications\TemplateEmail;
use App\Screening;
use App\Step;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ScreeningController extends Controller
{
    public function index($id = 0)
    {
        $this->preProcessingCheck('edit_cycles');
        $steps = Step::where('stype', 2)->orderBy('from')->get();
        $judges = User::join('model_has_roles', 'id', 'model_id')->where('role_id', 7)->get();
        if ($id == 0) {
            $id = $steps->pluck('id')->first();
            $cstep = Step::where('stype', 2)->where('id', $id)->first();
        } else {
            $cstep = Step::where('stype', 2)->where('id', $id)->first();
        }
        if ($cstep) {$form = Step::where('cycle_id', $cstep->cycle_id)->where('stype', 1)->where('arr', $cstep->arr - 1)->first();}
        else {$form=[];}
        $svgs = ['notebook', 'search', 'idea', 'comments', 'trophy'];
        return view('admin.settings.screening.index', compact('cstep', 'judges', 'form', 'steps', 'id', 'svgs'));
    }

    public function update(Request $request)
    {
        if ($request->step) {
            $type = Step::where('id', $request->step)->pluck('data')->first();
            $list = $request->judges;
            $notifylist = User::whereIn('id',array_values($list))->get();
            Step::where('id', $request->step)->update(['list' => json_encode($list)]);
            Screening::where('step_id', $request->step)->delete();
            Formdata::where('form_id', $request->fid)->update(['step_id' => $request->step, 'screening' => '{}', 'comments' => '{}']);
            if ($list) {
                if ($type == 'grouptogroup') {
                    foreach ($list as $key => $panel) {
                        $cpanel = $key;
                        foreach ($panel as $user) {
                            $users = json_decode($request->{'panel'.$cpanel});
                            if ($users=="") {
                                Screening::insert(['step_id' => $request->step,'user_id' => $user, 'panel' => $cpanel ]);
                            } else {
                                Screening::insert(['step_id' => $request->step,'user_id' => $user, 'panel' => $cpanel,'users'=> json_encode($users) ]);
                            }
                        }
                    }
                } else {
                    foreach ($list as $user) {
                        Screening::updateOrCreate(['step_id' => $request->step, 'user_id' => $user, 'panel' => 0]);
                    }
                }
                /// notify user via Mail if notify enabled
                if ($request->notify) {
                $cstep = Step::findOrFail($request->step);
                foreach ($notifylist as $rname) {
                $user = new User();
                $user->email = $rname->email;
                $user->id = $rname->id;
                $rfullname = $rname->first_name_en ." ". $rname->last_name_en;
                $MSG = new TemplateEmail;
                $MSG->Message=["New judging - VI portal","Dear ".$rfullname.",","Kindly note that we need your experiences to judge New Incubation Cycle registered users, the judging period starting from ".$cstep->from->format('d-m-Y').
                    " to ". $cstep->to->format('d-m-Y') .", Check your account for more details.","/admin"];
                $user->notify($MSG); }}
                /// End of mail send
            }
            return Redirect::back()->with('message', 'Saved');
        } else {
            return Redirect::back()->with('message2', 'error');
        }
    }

    public function view($fid, $cid)
    {
        // Insure answers belong to Judger first
        $answers = Formdata::where('form_id', $fid)->where('company_id', $cid)->orderBy('field_id', 'ASC')->get();
        $company = Company::where('id', $answers->pluck(['company_id'])->first())->first();
      	if(count($answers)==0) {return Redirect::back()->with('msg', 'error');}
        return view('admin.settings.screening.form', compact('answers', 'company'));
    }

    public function save(Request $request)
    {
        $answers = Formdata::where('form_id', $request->form_id)->where('company_id', $request->company_id)->orderBy('field_id', 'ASC')->get(['field_id']);

        $user = Auth::id();

        foreach ($answers as $answer) {

            Formdata::where('field_id', $answer->field_id)->where('company_id', $request->company_id)
                ->update(['screening->' . $user => $request->{'w' . $answer->field_id}, 'comments->' . $user => $request->{'c' . $answer->field_id}]);
        }
        return Redirect::route('admin')->with('msg', 'Saved');
    }

    public function add(Request $request)
    {
        $list = json_encode($request->panelusers);
        if ($list) {
            Screening::where('step_id', $request->sid)->where('panel', $request->pid)->update(['users' => $list]);
            return Redirect::back()->with('message', 'Saved');
        } else {
            return Redirect::back()->with('message2', 'Error');
        }
    }

    public function getusers($fid, $sid, $pid)
    {
        $list = Screening::where('step_id', $sid)->where('panel', $pid)->first(['users']);
        $outlist = Screening::where('step_id', $sid)->where('panel', '<>', $pid)->pluck('users');
        $outlist ? $outlist = ('['.str_replace(['[',']'],'',json_encode($outlist)).']') : $outlist = [];
        $menu = $selected = '';
        $l = session()->get('locale') ?? 'ar';
        foreach (Company::whereIn('step', [$fid,$sid])->get() as $comp) {
            if (in_array($comp->id,  $list['users'] ?? [])) {
                $selected = " selected ";
            }
            if (in_array($comp->id, json_decode($outlist) ?? [])) {
                $selected = " disabled='disabled' ";
            }
            $menu = $menu . '<option value="' . $comp->id . '"' . $selected . '>' . $comp->{'name_' . $l} . '</option>';
            $selected = '';
        }
        return $menu;
    }

    public function results($id = 0)
    {
        $this->preProcessingCheck('edit_cycles');
        $steps = Step::where('stype', 2)->orderBy('from')->get();
        if ($id == 0) {
            $id = $steps->pluck('id')->first();
            $cstep = Step::where('stype', 2)->where('id', $id)->first();
        } else {
            $cstep = Step::where('stype', 2)->where('id', $id)->first();
        }
        $judges = User::join('screenings', 'user_id', 'id')->where('step_id', $id)->get();
        $form = null;
        if ($cstep) {$form = Step::where('cycle_id', $cstep->cycle_id)->where('stype', 1)->where('arr', $cstep->arr - 1)->first();}
        $svgs = ['notebook', 'search', 'idea', 'comments', 'trophy'];
        return view('admin.settings.screening.results', compact('cstep', 'judges', 'form', 'steps', 'id', 'svgs'));
    }

    public function changestep(Request $request)
    {
            $this->preProcessingCheck('edit_cycles');
            $approved = $by = null;
            if ($request->step==0) {
                $by = Auth::id();
            } else {
                $cstep = Step::where('id', $request->step)->first(['arr']);
                if ($cstep->arr > 1) {$approved=1;$by=Auth::id();}
            }
            $update = Company::where('id',$request->company)->update(['step'=>$request->step, 'approved'=>$approved, 'approved_by'=>$by]);
            /// notify user via Mail
            $rname = User::where('company_id',$request->company)->first();
            $user = new User();
            $user->email = $rname->email;
            $user->id = $rname->id;
            $rfullname = $rname->first_name_en ." ". $rname->last_name_en;
            $MSG = new TemplateEmail;
            $MSG->Message=["Step changed - VI portal","Dear ".$rfullname.",","Your step into Cycle changed, check your account now.","/admin"];
            $user->notify($MSG);
            /// End of mail send
            if ($update) {
            return response()->json(['state' => 'success'], 200);
            } else {
            return response()->json(['state' => 'failed'], 500);
            }
    }
}