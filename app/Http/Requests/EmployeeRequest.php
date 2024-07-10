<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('employees', 'name')->ignore($this->route('employee')),
            ],
              'email' => [
                'required',
                Rule::unique('employees', 'email')->ignore($this->route('employee')),
            ],

            'country_id' => 'required',
            'city_id' => 'required',
            'state_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'country_id' => 'Country',
            'city_id' => 'City',
            'state_id' => 'State'
        ];
    }
}
