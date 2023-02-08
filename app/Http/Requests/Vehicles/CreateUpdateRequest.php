<?php

namespace App\Http\Requests\Vehicles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
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
            'license_plate'     =>  [
                'required',
                'string',
                'max:10',
                Rule::unique('vehicles')->ignore($this->vehicle)
            ],
            'color'             =>  'required|string|max:50',
            'brand'             =>  'required|string|max:100',
            'type'              =>  'required|string|in:public,private',
            'owner_id'          =>  'required|numeric',
        ];
    }
}
