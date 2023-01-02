<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class StoreUpdateClientCompanyRequest extends FormRequest
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

        $companyId = Auth::user()->company_id;
        //make sure that, the ID is number
        !is_numeric ($companyId)? $id=0: '';
        return [
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'name_en' => ['required', 'string'],
            'name_ar' => ['required', 'string'],
            'address_en' => ['required', 'string'],
            'address_ar' => ['required', 'string'],
            'phone' => ['required'],
            'email' => 'email|required|unique:companies,email,' .$companyId,
        ];
    }
}
