<?php
namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTermlyRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust if you need role-based checks
    }

    public function rules(): array
    {
        $companyId = company()->id;
        $registrationId = $this->route('termly_registration_id'); // assumes route model binding or ID in URL

        return [
            'residence' => ['required', Rule::in(['boarding', 'day'])],
            'new_or_continuing' => ['required', Rule::in(['new', 'continuing'])],
            'clazz_id' => ['required', 'exists:clazzs,id'],
            'hostel_id' => ['nullable', 'exists:hostels,id'],
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('termly_registrations')
                    ->where(fn ($q) => $q->where('company_id', $companyId)
                                         ->where('term_id', $this->term_id))
                    ->ignore($registrationId),
            ],
            'term_id' => ['required', 'exists:terms,id']
        ];
    }
}