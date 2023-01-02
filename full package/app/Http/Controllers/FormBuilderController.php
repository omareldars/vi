<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB, Mail};
use App\BuilderForm;
use App\BuilderField;
use App\Field;

class FormBuilderController extends Controller
{
    /**
     * show the builder
     */
    public function showBuilder($id=1) {
        $this->preProcessingCheck('edit_forms');
        $title = BuilderForm::find($id);
        if (!$title){
            $title = BuilderForm::first();
            if (!$title){
                $title = BuilderForm::firstOrCreate(['form_name'=>'New Empty Form']);
            }
            $id = $title->id;
        }
        $fields = Field::all()->mapWithKeys(function ($field) {
            return [$field->field_type => $field->id];
        });


        $builder_fields = BuilderField::where('builder_form_id', $id)->orderBy('id', 'asc');

        if($builder_fields->exists()) {

            $field_data = $builder_fields->get()->map(function($field) use ($fields) {

                switch ($fields->search($field->field_id)) {
                    case 'select':
                        $field_config_data = [
                            'type'=> 'select',
                            'additionalConfig'=> [
                                'listOptions' => $field->options->values
                            ]
                        ];

                        break;

                    case 'textarea':
                        $field_config_data = [
                            'type'=> 'textarea',
                            'additionalConfig'=> [
                                'textAreaRows' => $field->options->rows
                            ]
                        ];

                        break;
                    case 'file':
                        $field_config_data = [
                            'type'=> 'file',
                            'additionalConfig'=> [
                                'inputType' => $field->options->type
                            ]
                        ];

                        break;

                    default:
                        if($field->options->type != "date") {
                            $field_config_data = [
                                'type'=> 'input',
                                'additionalConfig'=> [
                                    'inputType' => $field->options->type
                                ]
                            ];
                        }
                        else {
                            $field_config_data = [
                                'type'=> 'date',
                                'additionalConfig'=> []
                            ];
                        }

                }

                $common_data = [
                    'id' => $field->id,
                    'label'=> $field->options->label,
                    'isRequired'=> $field->options->validation->required == 1? true : false,
                ];

                return [array_merge($common_data, $field_config_data)];
            });
        }

        $data = [
            'title' => 'form builder',
            'builder_data' => $builder_fields->exists()? $field_data->flatten(1)->toArray() : []
        ];

        return view('admin.settings.formbuilder.index', $data)->with('title',$title);
    }

    /**
     * show the form
     */
    public function showForm($id) {
        $this->preProcessingCheck('view_forms');
        $form_id_toshow = $id;
        $the_form = BuilderForm::findOrFail($form_id_toshow);
        $field_map_ids = BuilderField::where('builder_form_id', $form_id_toshow)->select('id')->pluck('id')->toArray();

        $data = [
            'title' => 'the form',
            'fields' => $the_form->fields()->orderBy('builder_fields.id', 'asc')->get(),
            'buolderform_id' => $form_id_toshow,
            'field_ids' => implode(",", $field_map_ids)
        ];

        return view('admin.settings.formbuilder.form', $data)->with('id',$id);
    }

    /**
     * handle form submit request
     */
    public function handleFormRequest(Request $request) {
        $this->preProcessingCheck('edit_forms');
        // must have data
        $validator = Validator::make($request->all(), [
            'builder_form_id' => 'required|integer|exists:builder_forms,id',
            'field_ids' => 'required|string',
        ]);

        abort_if($validator->fails(), 422, "Data error");

        // generating validation rules based on dynamic field config data
        $field_map_ids = explode(",", $request->input('field_ids'));
        $field_required_rules = collect($field_map_ids)->mapWithKeys(function($id){
        $field_options = BuilderField::findOrFail($id)->options;
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

        // validation based on dynamic data
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
        $form_data = collect($field_map_ids)->mapWithKeys(function($id) use ($request){
            $field_options = BuilderField::findOrFail($id)->options;
            $field_name = 'field_'. $id;
            return [
                $field_name => [
                    $field_options->label, $request->input($field_name)
                ]
            ];
        });

        return redirect()->back()->with('BuilderForm work correctly.', 1);
    }

    /**
     * handle form data ajax request save
     */
    public function saveForm($id, Request $request) {
        $this->preProcessingCheck('edit_forms');
        $request->validate([
            'form_fields_data' => 'required|json'
        ]);

        $fields = Field::all()->mapWithKeys(function ($field) {
            return [$field->id => $field->field_type];
        });

        // data from ajax request
        $field_data = collect(json_decode($request->form_fields_data));

        $config = $field_data->map(function($field) use ($fields){
            switch ($field->type) {
                case 'input':
                    $field_id = $fields->search('input');

                    $additional_config = ['type' => $field->additionalConfig->inputType];
                    break;

                case 'select':
                    $field_id = $fields->search('select');

                    $values = collect($field->additionalConfig->listOptions)->map(function($opt){
                        return trim($opt);
                    })->implode(',');

                    $additional_config = ['values' => $values];
                    break;

                case 'textarea':
                    $field_id = $fields->search('textarea');

                    $additional_config = ['rows' => $field->additionalConfig->textAreaRows];
                    break;

                case 'date':
                    $field_id = $fields->search('input');
                    $additional_config = ['type' => 'date'];
                    break;

                case 'file':
                    $field_id = $fields->search('file');
                    $additional_config = ['type' => $field->additionalConfig->inputType];
                    break;

                default:
                    $field_id = 0;
                    $additional_config = [];
                    break;
            }

            $common_data = [
                'label' => $field->label,
                'validation' => [
                    'required' => $field->isRequired ? 1 : 0
                ]
            ];

            return ['field' => $field_id, 'options' => array_merge($common_data, $additional_config)];
        });

        // attempt data save
        $save_success = 1;
        $this->id = $id;
        DB::transaction(function () use ($config,$id) {
            try {
                BuilderForm::findOrFail($id)->fields()->detach();
                $config->each(function($item){
                    BuilderForm::findOrFail($this->id)->fields()->attach($item['field'],
                        [
                            'options' => json_encode($item['options'])
                        ]);
                });
            } catch (Exception $e) {
                $save_success = 0;
            }
        });

        return response()->json([
            'success' => $save_success
        ]);
    }

    public function modifyForm($set, Request $request) {
        $this->preProcessingCheck('edit_forms');

        if ($set==1) {
            // make a copy
            $form = new BuilderForm;
            $form->form_name = $request->title;
            $form->save();
            $new = BuilderField::where('builder_form_id',$request->id)->orderBy('id')->get();
            if (count($new)>0) {
                foreach ($new as $n){
                    $save = BuilderField::findOrFail($n->id)->replicate();
                    $save->builder_form_id = $form->id;
                    $save->save();
                                    }
                                }
            return response()->json($form->id);
        } elseif ($set==2) {
            // create new
            $new = new BuilderForm;
            $new->form_name = $request->title;
            $new->save();
            return response()->json($new->id);
        } elseif ($set==3) {
            // delete
            BuilderForm::findOrFail($request->id)->fields()->detach();
            BuilderForm::destroy($request->id);
            return response()->json();
        } else {
            //rename
            BuilderForm::where('id',$request->id)->update(['form_name'=>$request->title]);
            return response()->json($request->id);
        }

    }
}
