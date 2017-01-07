<?php

namespace App\Http\Requests;

class ContactRequest extends Request
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
            'name' => 'required',
            'email' => 'required|email',
            'content' => 'required',
        ];
    }

    /**
     * Define custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'Required',
            'email' => 'Invalid Email',
        ];
    }
}
