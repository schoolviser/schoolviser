<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTertiaryStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // TODO: make this configurable per company (true/false)
        $enforceUniquePhone = false; // for now, phone numbers are not unique

        $rules = [
            'regno'           => 'nullable|unique:students,regno',
            'school_pay_code' => 'nullable|unique:students,school_pay_code',
            'photo'           => 'nullable|mimes:jpeg,bmp,png',
            'first_name'      => 'required|min:3|max:50',
            'last_name'       => 'required|min:3|max:50',
            'email'           => 'nullable|email|unique:students,email',
            'dob'             => 'nullable|date',
            'entry_date'      => 'nullable|date',
            'country'         => 'nullable|max:100',
            'phone'           => ['nullable', 'max:20'],
        ];

        if ($enforceUniquePhone) {
            $rules['phone'][] = Rule::unique('students', 'phone')
                ->where(function ($query) {
                    return $query->where('company_id', company()->id);
                });
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'regno.unique'           => 'This registration number is already taken.',
            'school_pay_code.unique' => 'This school pay code is already taken.',
            'photo.mimes'            => 'Photo must be a jpeg, bmp, or png file.',
            'first_name.required'    => 'First name is required.',
            'last_name.required'     => 'Last name is required.',
            'email.unique'           => 'This email is already registered.',
            'dob.date'               => 'Date of birth must be a valid date.',
            'entry_date.date'        => 'Entry date must be a valid date.',
            'country.max'            => 'Country name is too long.',
            'phone.max'              => 'Phone number must not exceed 20 characters.',
            'phone.unique'           => 'This phone number is already registered for your company.',
        ];
    }
}
