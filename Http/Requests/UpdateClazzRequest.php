<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClazzRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow all authenticated users, or add your own logic
        return true;
    }

    public function rules(): array
    {
        $companyId = company()->id;
        $clazzId = $this->route('id'); // returns the numeric ID from the URL

        return [
            'name' => [
                'required',
                Rule::unique('clazzs')
                    ->where(fn ($q) => $q->where('company_id', $companyId))
                    ->ignore($clazzId),
            ],
            'abbr' => [
                'required',
                Rule::unique('clazzs')
                    ->where(fn ($q) => $q->where('company_id', $companyId))
                    ->ignore($clazzId),
            ],
            'code' => [
                'nullable',
                Rule::unique('clazzs')
                    ->where(fn ($q) => $q->where('company_id', $companyId))
                    ->ignore($clazzId),
            ],
            'level' => [
                'nullable',
                Rule::in(['ordinary', 'advanced']),
            ],
        ];
    }
}