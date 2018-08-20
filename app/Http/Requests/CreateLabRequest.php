<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLabRequest extends FormRequest
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

        return [
            'name'       => 'required|string|min:3|unique:labs,name',
            'short_name' => 'nullable|string|min:3|unique:labs,short_name',
            'url'        => 'nullable|url'
        ];
    }
}
