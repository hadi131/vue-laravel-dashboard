<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required | email | unique:employees,email',

            'country_id'=>'required',
            'city_id'=>'required',
            'state_id'=>'required'
        ];
    }
    public function messages()
    {
        return [
            "name.required" => ':attribute is required!',
            "email.required" => ':attribute is required!',
            "email.email" => 'Enter correct :attribute!',
            "email.unique" => ':attribute Already Registered!',

            'country_id'=>':attribute is required',
            'city_id'=>':attribute is required',
            'state_id'=>':attribute is required'

        ];
    }
    public function attributes()
    {
        return [
            'name' => 'User Name',
            'email' => 'User Email',

            'city' => 'User City',
            'country_id'=>'Country',
            'city_id'=>'City',
            'state_id'=>'State'
        ];
    }
}
