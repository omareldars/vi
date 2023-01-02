<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        if(StoreUserRequest::hasFile('img_url')){

            return [
                'first_name_en' => ['required', 'string', 'max:255'],
                'last_name_en' => ['required', 'string', 'max:255'],
                'phone' => ['required'],
                'email' => 'email|required|unique:users,email',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => 'required',
                'img_url' => 'required|image|mimes:jpeg,bmp,png,jpg,gif',
            ];

        }else{
        
            return [
                'first_name_en' => ['required', 'string', 'max:255'],
                'last_name_en' => ['required', 'string', 'max:255'],
                'phone' => ['required'],
                'email' => 'email|required|unique:users,email',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => 'required',
            ];
        }
    }

    
}
