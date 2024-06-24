<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ConvertRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     **/
    public function rules(): array
    {
        return [
            'integer' => ['required', 'integer','min:1', 'max:3999'],
            //'Accept' => 'required|in:application/json',
        ];

    }

    public function messages()
    {
        return [
            'integer.max' => 'The integer value must be between 1 and 3999.',
        ];
    }
}
