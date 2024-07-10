<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LanguageRequest extends FormRequest
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
                Rule::unique('languages', 'name')->ignore($this->route('language')),
            ],
              'code' => [
                'required',
                Rule::unique('languages', 'code')->ignore($this->route('language')),
            ],

        ];
    }

    public function attributes()
    {
        return [
            'name'=>'Language Name',
            'code'=>'Language Code',
        ];
    }
}
