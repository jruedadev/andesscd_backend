<?php

namespace App\Http\Requests\Drivers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type_document'     =>  'required|string|in:CC,CE,NIT,OTRO',
            'document'          =>  [
                'required',
                'string',
                'max:20',
                Rule::unique('drivers')->ignore($this->driver)
            ],

            'first_name'        =>  'required|string|max:50',
            'middle_name'       =>  'required|string|max:50',
            'last_name'         =>  'required|string|max:50',

            'address'           =>  'required|string|max:250',
            'phone'             =>  'required|string|max:20',
            'city'              =>  'required|string|max:100',

            'vehicles'          =>  'nullable|array',
            'vehicles.*'        =>  'nullable|numeric',
        ];
    }
}
