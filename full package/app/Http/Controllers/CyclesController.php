<?php

namespace App\Http\Controllers;

use App\BuilderField;
use App\FinalData;
use App\Finalscreening;
use App\Formdata;
use App\Formfield;
use App\Screening;
use App\TrainingSession;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Cycle;
use App\Step;
use App\Form;
use App\BuilderForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CyclesController extends Controller
{
    public function index($id=0)
    {
        $this->preProcessingCheck('edit_cycles');
        $cycles = Cycle::orderBy('start','DESC')->get();
        $steps=null;
        if (count($cycles)>0) {
        if ($id==0) {
            $id = $cycles->pluck('id')[0];
            $steps = Step::where('cycle_id', $id)->orderBy('arr')->get();
        } else {
            $steps = Step::where('cycle_id', $id)->orderBy('arr')->get();
        }}
        $svgs = ['notebook','search','idea','comments','trophy'];
        return view('admin.settings.cycles.index',compact('cycles','steps','id','svgs'));
    }

    public function users($id)
    {
        $this->preProcessingCheck('edit_cycles');
        if ($id==0) {
            $cycles = Cycle::orderBy('id','DESC')->get();
            $id = $cycles->pluck('id')[0];
        } else {
            $cycles = Cycle::all();
        }
        return view('admin.settings.cycles.users',compact('cycles','id'));
    }

    public function modify(Request $request)
    {
        $this->preProcessingCheck('edit_cycles');
        $id = $request->cycleid;
        $type = $request->type;
    if ($type==1) {
        /// Edit Cycle
        $private = null;
        if ($request->private) {$private=sha1(now());}
        Cycle::where('id',$id)->update(['title'=>$request->title, 'description'=>$request->description,'start'=>Carbon::parse($request->start), 'end'=>Carbon::parse($request->end), 'private'=>$private]);
        return redirect()->back()->with('message', 'Saved');
    } elseif ($type==2) {
        /// Save Cycle
        $private = null;
        if ($request->private) {$private=sha1(now());}
        Cycle::insert(['title'=>$request->title, 'description'=>$request->description, 'start'=>Carbon::parse($request->start), 'end'=>Carbon::parse($request->end), 'private'=>$private]);
        return redirect()->back()->with('message', 'Saved');
    } elseif ($type==3) {
        /// Delete Cycle steps contents
        $delsteps = Step::where('cycle_id',$id)->get();
        foreach ($delsteps as $onestep) {
            Formfield::where('step_id',$onestep->id)->delete();
            Screening::where('step_id',$onestep->id)->delete();
            Formdata::where('form_id',$onestep->id)->delete();
            Finalscreening::where('step_id',$onestep->id)->delete();
            FinalData::where('step_id',$onestep->id)->delete();
            TrainingSession::where('step_id',$onestep->id)->delete();
        }
        /// Delete Step
        Step::where('cycle_id',$id)->delete();
        /// Delete Cycle
        Cycle::destroy($id);
        return Response()->json('Cycle deleted');
    } elseif ($type==4) {
        /// arrange steps
        $i = 1;
        foreach ($request->steps as $id) {
            Step::where('id',$id)->update(['arr'=>$i++]);
            }
        return Response()->json('Arranged ');
    } elseif ($type==5) {
        /// add new step
        $stype = $request->stype;
        $data = null;
        if ($stype==1) {
            $data = $request->FormSelect;
            $id = Step::insertGetId(['cycle_id'=>$request->cid, 'title'=>$request->title, 'description'=>$request->description, 'stype'=>$stype, 'data'=>$data,
            'arr'=>$request->arr, 'from'=>$request->fromDate, 'to'=>$request->toDate]);
            // make a copy of form fields
            $new = BuilderField::where('builder_form_id',$data)->orderBy('id')->get();
            if (count($new)>0) {
                foreach ($new as $n){
                    Formfield::insert([
                        'step_id'=>$id,
                        'field_id'=>$n->field_id,
                        'options'=>json_encode($n->options)
                    ]);
                }}
        } elseif ($stype==2) {
            // add Screening
            Step::insert(['cycle_id' => $request->cid, 'title' => $request->title, 'description' => $request->description, 'stype' => $stype, 'data' => $request->ScreeningSelect,
                'arr' => $request->arr, 'from' => $request->fromDate, 'to' => $request->toDate]);
        } elseif ($stype==3) {
            // add step
            Step::insert(['cycle_id' => $request->cid, 'title' => $request->title, 'description' => $request->description, 'stype' => $stype, 'data' => null,
                'arr' => $request->arr, 'from' => $request->fromDate, 'to' => $request->toDate]);
        } elseif ($stype==4) {
            // add training
            Step::insert(['cycle_id' => $request->cid, 'title' => $request->title, 'description' => $request->description, 'stype' => $stype,'list'=>$request->RecordedSelect, 'data' => null,
                'arr' => $request->arr, 'from' => $request->fromDate, 'to' => $request->toDate]);
        } elseif ($stype==5) {
            // add service
        $data = $request->FinalScreeningSelect;
        $fform = $request->FormSelect;
        if (!$fform) {return redirect()->back()->with('message', 'You must add form first'); }
        $id = Step::insertGetId(['cycle_id' => $request->cid, 'title' => $request->title, 'description' => $request->description, 'stype' => $stype, 'data' => $data,
            'arr' => $request->arr, 'from' => $request->fromDate, 'to' => $request->toDate]);
            // make a copy of form fields
            $new = BuilderField::where('builder_form_id',$fform)->orderBy('id')->get();
            if (count($new)>0) {
                foreach ($new as $n){
                    Formfield::insert([
                        'step_id'=>$id,
                        'field_id'=>$n->field_id,
                        'options'=>json_encode($n->options)
                    ]);
                }}
        }
        return redirect()->back()->with('message', 'Saved');
    } elseif ($type==6) {
        /// Delete step
        $cid = $request->stepid;
        if ($request->steps) {$steps = $request->steps;}
        else {$steps=Step::where('cycle_id',Step::where('id',$cid)->pluck('cycle_id')->first())->pluck('id')->toArray();}

        //// Delete step contents
        Formfield::where('step_id',$cid)->delete();
        Screening::where('step_id',$cid)->delete();
        Formdata::where('form_id',$cid)->delete();
        Finalscreening::where('step_id',$cid)->delete();
        FinalData::where('step_id',$cid)->delete();
        TrainingSession::where('step_id',$cid)->delete();
        Step::destroy($cid);
        // Arrange steps
        $i = 1;
        $steps = array_diff($steps, [$cid]);
        foreach ($steps as $id) {
                    Step::where('id', $id)->update(['arr' => $i++]);
        }
        return Response()->json('Step deleted' );
    } elseif ($type==7) {
       // Modify step
        $step = Step::where('id', $request->sid)->first()->toArray();
        return response()->json($step);
    } elseif ($type==8) {
        /// deleted saved data if type changed
        if ($request->ScreeningSelect!==null && Step::where('id',$request->sid)->pluck('data')->first()!=$request->ScreeningSelect) {Formdata::where('step_id',$request->sid)->update(['screening'=>null,'comments'=>null]);}
        /// Save Modified step
        if ($request->ScreeningSelect) {
            Step::where('id', $request->sid)->update(['title' => $request->title, 'description' => $request->description,'data' => $request->ScreeningSelect,'list'=>null, 'from' => Carbon::parse($request->fromDate), 'to' => Carbon::parse($request->toDate)]);
        } elseif ($request->ServiceSelect) {
            Step::where('id', $request->sid)->update(['title' => $request->title, 'description' => $request->description,'data' => $request->ServiceSelect,'list'=>null, 'from' => Carbon::parse($request->fromDate), 'to' => Carbon::parse($request->toDate)]);
        } elseif ($request->TrainingSelect) {
            Step::where('id', $request->sid)->update(['title' => $request->title, 'description' => $request->description,'data' => $request->TrainingSelect,'list'=>$request->RecordedSelect, 'from' => Carbon::parse($request->fromDate), 'to' => Carbon::parse($request->toDate)]);
        } elseif ($request->FinalScreeningSelect){
            Step::where('id', $request->sid)->update(['title' => $request->title, 'description' => $request->description,'data' => $request->FinalScreeningSelect,'list'=>null, 'from' => Carbon::parse($request->fromDate), 'to' => Carbon::parse($request->toDate)]);
        } else {
            Step::where('id', $request->sid)->update(['title' => $request->title, 'description' => $request->description, 'from' => Carbon::parse($request->fromDate), 'to' => Carbon::parse($request->toDate)]);
        }
        return redirect()->back()->with('message', 'Saved');
    } else {
        // Show Cycle
        $cycles = Cycle::where('id', $id)->first()->toArray();
        return response()->json($cycles);
            }
    }
    function view ($c,$s=0,Request $request) {
        // Check Company ---> forward to profile
        if (!Auth::user()->HaveCompany) {return redirect()->route('my_profile')->with(['msg' => 'You need to enable "Have a company" first.', 'class' => 'danger']);}
        if (!Auth::user()->company) {return redirect()->route('my_company')->with(['msg' => 'You need to add your company details first.', 'class' => 'danger']);}
        // Check enrolled in Cycle
        if (Auth::user()->company->cycle && Auth::user()->company->cycle != $c) {return redirect()->back()->with(['msg' => 'You already enrolled in a cycle.', 'class' => 'danger']);}
        //Check private
        $private = Cycle::findOrFail($c);if ($private->private!=Input::get('id')) {abort(404);}
        // Check STEPS
        if (!Auth::user()->company->cycle || Auth::user()->company->cycle == $c) {
                $step = Step::where('cycle_id',$c)->orderBy('arr')->first();
                if ($step->stype!=1) {return redirect()->back()->with(['msg' => 'The selected cycle doesn\'t contain a data form.', 'class' => 'danger']);}
                if ($step->to<now()->format('Y-m-d')){return redirect()->back()->with(['msg' => 'Error can\'t open form, Registration timed out.', 'class' => 'danger']);}
                $id = $step->id;
                $field_map_ids = Formfield::where('step_id',$id )->select('id')->pluck('id')->toArray();
                $answers = [];
                $data = [
                    'title' => $step->title,
                    'fields' => $step->fields()->orderBy('form_fields.id', 'asc')->get(),
                    'form_id' => $step->id,
                    'field_ids' => implode(",", $field_map_ids)
                ];
            if (Auth::user()->company->step==$id) {
                $answers = Formfield::join('form_data', 'form_fields.id', 'form_data.field_id')->where('user_id',Auth::id())->orderBy('id', 'ASC')->select('answer')->pluck('answer')->toArray();
            }
                return view('admin.settings.cycles.form', $data)->with('step',$step)->with('c',$c)->with('answers',$answers);;
        }
    }
    function my ($id) {
            $step = Step::where('stype',1)->where('id',$id)->first();
            if (!$step) {return redirect()->back()->with(['msg' => 'Error opening the selected form.', 'class' => 'danger']);}
            if ($step->to<now()->format('Y-m-d')){return redirect()->back()->with(['msg' => 'Error can\'t open form, step timed out.', 'class' => 'danger']);}
            $id = $step->id;
            $field_map_ids = Formfield::where('step_id',$id )->select('id')->pluck('id')->toArray();
            $answers = [];
            $data = [
                'title' => $step->title,
                'fields' => $step->fields()->orderBy('form_fields.id', 'asc')->get(),
                'form_id' => $step->id,
                'field_ids' => implode(",", $field_map_ids)
            ];
            if (Auth::user()->company->step==$id) {
                $answers = Formfield::join('form_data', 'form_fields.id', 'form_data.field_id')->where('user_id',Auth::id())->orderBy('id', 'ASC')->select('answer')->pluck('answer')->toArray();
            }
            return view('admin.settings.cycles.form', $data)->with('step',$step)->with('c',$step->cycle_id)->with('answers',$answers);;
        }


    public function saveForm(Request $request) {
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
        foreach($field_map_ids as $fid){
            $field_options = Formfield::findOrFail($fid)->options;
            $field_name = 'field_'. $fid;
            $uid = Auth::id();
            $cid = Auth::user()->company->id;
            Formdata::where('field_id',$fid)->where('company_id',$cid)->delete();
            Formdata::updateOrInsert(['field_id'=>$fid,'company_id'=>$cid,'user_id'=>$uid,'form_id'=>$id,'step_id'=>Auth::user()->company->step, 'question'=>$field_options->label,'answer'=>$request->input($field_name),'screening'=>'{}','comments'=>'{}']);
        }
        // update cycle & step
        Auth::user()->company->update(['cycle'=>$request->cycle,'step'=>$request->id]);
        return Redirect::back()->with(['msg' => 'StoredSuccessfully','class'=>'success']);
    }
}