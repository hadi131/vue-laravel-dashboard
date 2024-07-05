<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
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

            'name' => 'required | unique:states,name,' . $this->country['id'],
        ];
    }
    public function messages()
    {
        return [
            "name.required" => ':attribute is required!',
            "name.unique" => ':attribute already registered!',


        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Country Name',

        ];
    }
}