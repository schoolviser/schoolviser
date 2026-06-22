<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClazzRequest extends FormRequest
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
                Rule::unique('clazzs')->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
            'abbr' => [
                'required',
                Rule::unique('clazzs')->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
            'code' => [
                'nullable',
                Rule::unique('clazzs')->where(fn ($q) => $q->where('company_id', $companyId)),
            ],
            'level' => [
                'nullable',
                Rule::in(['ordinary', 'advanced']),
            ],
        ];
    }
}