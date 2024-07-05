<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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

            'name' => 'required | unique:states,name,' . $this->city['id'],
            'state_id'=>'required'

        ];
    }
    public function messages()
    {
        return [
            "state_id.required" => ':attribute is required!',
            "name.required" => ':attribute is required!',
            "name.unique" => ':attribute already registered!',


        ];
    }
    public function attributes()
    {
        return [
            'name' => 'City Name',
            'state_id' => 'State Name',

        ];
    }
}
