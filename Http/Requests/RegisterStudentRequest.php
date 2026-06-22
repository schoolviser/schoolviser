<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStudentRequest extends FormRequest
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
            'regno' => 'nullable|unique:students,regno',
            'photo' => 'nullable|mimes:jpeg,bmp,png',
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'nullable|email|unique',
            'dob' => 'required|date',
            'entry_date' => 'nullable|date',
            'country' => 'nullable|max:100',
            'residence' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'dob.required' => 'Student date of birth is required'
        ];
    }
}
