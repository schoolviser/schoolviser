<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    public function rules(): array
    {
        $companyId = company()->id;

        return [
            'regno'             => 'nullable|string|max:50',
            'photo'             => 'nullable|mimes:jpeg,bmp,png',
            'first_name'        => 'required|min:3|max:50',
            'last_name'         => 'required|min:3|max:50',
            'dob'               => 'required|date',
            'entry_date'        => 'nullable|date',
            'country'           => 'nullable|max:100',
            'school_pay_code'   => 'nullable|string|max:100',
            'new_or_continuing' => 'required|in:new,continuing',
            'residence'         => 'required|in:day,boarding',
            'clazz_id'          => 'required|exists:clazzs,id',

            // Scoped uniqueness per company
            'nin' => [
                'nullable',
                'string',
                Rule::unique('students')->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
            'phone' => [
                'nullable',
                'string',
                Rule::unique('students')->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('students')->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}