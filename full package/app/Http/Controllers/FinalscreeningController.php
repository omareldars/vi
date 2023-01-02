<?php

namespace App\Http\Controllers;

use App\Company;
use App\FinalData;
use App\Finalscreening;
use App\Formfield;
use App\Step;
use App\Traits\ZoomMeetingTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class FinalscreeningController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function index($id = 0)
    {
        $this->preProcessingCheck('edit_cycles');
        $steps = Step::where('stype', 5)->orderBy('from')->get();
        $judges = User::join('model_has_roles', 'id', 'model_id')->where('role_id', 7)->get();
        if ($id == 0) {
            $id = $steps->pluck('id')->first();
            $cstep = Step::where('stype', 5)->where('id', $id)->first();
        } else {
            $cstep = Step::where('stype', 5)->where('id', $id)->first();
        }
        $companies = Company::where('step',$id)->get();
        return view('admin.settings.final.index', compact('cstep', 'judges', 'steps', 'id','companies'));
    }

    public function update(Request $request)
    {
        if ($request->step) {
            $list = $request->judges;
           // dd();
            $companies = $request->users;
            if (!$companies or !$list) {return Redirect::back()->with('message2', 'You need to select judges and companies to update');}
            foreach ($companies as $company) {
                Finalscreening::where('company_id',$company)->where('step_id', $request->step)->delete();
                Finalscreening::insert(['company_id'=>$company,'step_id'=>$request->step, 'judges'=>json_encode($list)]);
            }
            return Redirect::back()->with('message', 'Saved');
        } else {
            return Redirect::back()->with('message2', 'error');
        }
    }

    public function view($sid, $cid)
    {
        // Insure company belong to Judger first
        $myid = Auth::id();
        $fs = Finalscreening::where('company_id',$cid)->where('step_id',$sid)->where('judges', 'like', "%\"{$myid}\"%")->get();
        if (!$fs) { return Redirect::back()->with('message2', 'error');}
        // Check step
        $step = Step::findOrFail($sid);
        if (!$step) {return Redirect::back()->with('message2', 'error');}
        $field_map_ids = Formfield::where('step_id',$sid)->orderBy('id')->select('id')->pluck('id')->toArray();
        $data = [
            'title' => $step->title,
            'fields' => $step->fields()->orderBy('form_fields.id', 'asc')->get(),
            'form_id' => $step->id,
            'field_ids' => implode(",", $field_map_ids)
        ];
        $answers = Formfield::join('final_data', 'form_fields.id', 'final_data.field_id')->where('judge_id',$myid)->
        where('company_id',$cid)->orderBy('id', 'ASC')->select('answer')->pluck('answer')->toArray();
        $company = Company::findOrFail($cid);
        return view('admin.settings.final.form', $data)->with('step',$step)->with('company', $company)->with('answers',$answers);
    }

    public function save(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:steps,id',
            'field_ids' => 'required|string',
        ]);
        abort_if($validator->fails(), 422, "Data error");
        // generating validation rules based on dynamic field config data
        $field_map_ids = explode(",", $request->input('field_ids'));
        $field_required_rules = collect($field_map_ids)->mapWithKeys(function($id){
            $field_options = Formfield::findOrFail($id)->options;
            if($field_options->validation->required == 1) {
                $rules = ['required'];
                if(isset($field_options->type) && $field_options->type == "email") $rules[] = 'email';
                return [
                    'field_'. $id => implode("|", $rules)
                ];
            }
            else {
                return ['field_'. $id => 'nullable'];
            }
        });
        $dynamic_validator = Validator::make($request->all(), $field_required_rules->toArray(), [
            'required' => "field can't be left blank",
            'email' => 'field must be a valid email address'
        ]);
        if ($dynamic_validator->fails()) {
            return redirect()->back()
                ->withErrors($dynamic_validator)
                ->withInput();
        }
        // gather the form data as field_name => [ label, data ]
        $uid = Auth::id();
        $cid = $request->cid;
        foreach($field_map_ids as $fid){
            $field_options = Formfield::findOrFail($fid)->options;
            $field_name = 'field_'. $fid;
            FinalData::where('field_id',$fid)->where('judge_id',$uid)->where('company_id',$cid)->delete();
            FinalData::updateOrInsert(['field_id'=>$fid, 'judge_id'=>$uid, 'company_id'=>$cid, 'step_id'=>$id, 'question'=>$field_options->label,'answer'=>$request->input($field_name)]);
        }
        return Redirect::back()->with(['msg' => 'StoredSuccessfully','class'=>'success']);
    }

    public function addzoom(Request $request)
    {
        if ($request->period) {
            $topic = "Final Screening (C" . $request->company . ')';
            $data = ['topic' => $topic, "start_time" => $request->date, 'duration' => $request->period, 'host_video' => 1, 'participant_video' => 1];
            $zoom = $this->create($data);
            if (!$zoom['success']) {
                return back()->with(['message2' => "API Error, can't create zoom meeting."]);
            }
            /// Notify users
            Finalscreening::where('step_id', $request->step)->where('company_id', $request->company)->update(['datetime' => $request->date, 'duration' => $request->period,
                'zoom_id' => $zoom['data']['id'], 'start_url' =>  $zoom['data']['start_url'], 'join_url' =>  $zoom['data']['join_url']]);
            return Redirect::back()->with('message', 'Meeting added successfully');
        } else {return Redirect::back()->with('message2', 'Error');}
    }
    public function results(Request $request,$id = 0)
    {
        $this->preProcessingCheck('edit_cycles');
        $steps = Step::where('stype', 5)->orderBy('from')->get();

        if ($id == 0) {
            $id = $steps->pluck('id')->first();
            $cstep = Step::where('stype', 5)->where('id', $id)->first();
        } else {
            $cstep = Step::where('stype', 5)->where('id', $id)->first();
        }
        $companies = Company::where('step',$id)->get();
        $c =  $cj = null;
        if ($request->c) {
            $c = Company::findOrFail($request->c);
            $cj = FinalData::where('company_id',$c->id)->where('step_id', $id)->distinct('judge_id')->get(['judge_id']);
        }
        return view('admin.settings.final.results', compact('cstep', 'steps', 'id','companies','c', 'cj'));
    }
}