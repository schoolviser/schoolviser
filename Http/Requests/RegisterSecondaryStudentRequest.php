<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSecondaryStudentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clazz_id'         => ['required', 'exists:clazzs,id'],
            'stream_id'        => ['required', 'exists:streams,id'],
            'term_id'          => ['required', 'exists:terms,id'],
            'new_or_continuing'=> ['required', 'in:new,continuing'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
