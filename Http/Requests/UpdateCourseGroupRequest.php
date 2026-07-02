<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courseGroupId = $this->input('course_group_id'); // injected from controller

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('course_groups', 'name')
                    ->ignore($courseGroupId, 'id')
                    ->where('company_id', company()->id)
                    ->where('term_id', $this->input('term_id'))
                    ->where('course_id', $this->input('course_id')),
            ],
            'short_code' => [
                'nullable',
                'string',
                'max:10',
                Rule::unique('course_groups', 'short_code')
                    ->ignore($courseGroupId, 'id')
                    ->where('company_id', company()->id)
                    ->where('term_id', $this->input('term_id')),
            ],
            'description' => 'nullable|string',
            'completes_on' => 'nullable|date',
            'course_id' => 'nullable|exists:courses,id',
            'term_id' => 'nullable|exists:terms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Group name is required.',
            'name.unique'        => 'This group name already exists for the selected course, term, and company.',
            'short_code.unique'  => 'This short code is already in use for your company and term.',
            'course_id.exists'   => 'Selected course does not exist.',
            'term_id.exists'     => 'Selected term does not exist.',
        ];
    }
}
