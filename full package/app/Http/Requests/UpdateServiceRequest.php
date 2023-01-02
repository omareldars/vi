<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(UpdateServiceRequest::hasFile('img_url')){
            return [
                'name_en' => 'required',
                'name_ar' => 'required',
                'description_en' => 'required',
                'description_ar' => 'required',
                'img_url' => 'required',
            ];
        }else{
            return [
                'name_en' => 'required',
                'name_ar' => 'required',
                'description_en' => 'required',
                'description_ar' => 'required',
            ];

        }
    }
}
