<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = company()->id;
        $courseId  = $this->route('id'); // your route uses {id}, not model binding

        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('courses')
                    ->where(fn ($q) => $q->where('company_id', $companyId))
                    ->ignore($courseId),
            ],
            'short_name' => [
                'nullable',
                'string',
                'max:10',
                Rule::unique('courses', 'abbr')
                    ->where(fn ($q) => $q->where('company_id', $companyId))
                    ->ignore($courseId),
            ],
            'duration' => [
                'nullable',
                'integer',
                'min:1',
                'max:10',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'department' => [
                'nullable',
                'exists:departments,id',
            ],
        ];
    }
}