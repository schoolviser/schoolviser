<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow all authenticated users, or add your own logic
        return true;
    }

    public function rules(): array
    {
        $companyId = company()->id;

        return [
            'name' => [
                'required',
                Rule::unique('courses')
                    ->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
            'abbr' => [
                'nullable',
                Rule::unique('courses')
                    ->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
            'award' => [
                'nullable',
                Rule::unique('courses')
                    ->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
            'duration' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'department_id' => [
                'nullable',
                'exists:departments,id',
            ],
            'meta' => [
                'nullable',
                'string',
            ],
        ];
    }
}