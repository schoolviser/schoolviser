<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow all authenticated users, or add custom logic
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'short_code'  => 'nullable|string|max:10|unique:course_groups,short_code,NULL,id,company_id,' . company()->id,
            'description' => 'nullable|string',
            'completes_on'=> 'nullable|date',
            'course_id'   => 'nullable|exists:courses,id',
            'term_id'     => 'nullable|exists:terms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Please provide a group name.',
            'short_code.unique'   => 'This short code is already in use for your company.',
            'course_id.exists'    => 'Selected course does not exist.',
            'term_id.exists'      => 'Selected term does not exist.',
        ];
    }
}
