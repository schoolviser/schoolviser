<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UpdateStudentPersonalInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Adjust authorization logic if needed
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'gender'     => ['required', 'in:male,female'],
            'dob'        => ['required', 'date', 'before:today'],
            'country'    => ['required', 'string', 'max:100'],
            'city'       => ['nullable', 'string', 'max:100'],
            'address'    => ['nullable', 'string', 'max:255'],
            'phone'      => ['required', 'string', 'max:20'],
            'nin'        => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'gender.required'     => 'Please select a gender.',
            'dob.before'          => 'Date of birth must be before today.',
            'regno.required'      => 'Registration number is required.',
            'phone.required'      => 'Phone number is required.',
        ];
    }
}