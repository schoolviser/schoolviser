<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Schoolviser\Repositories\AcademicYearRepository;
use Modules\Schoolviser\Entities\Term;

class UpdateTermRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'year_id' => 'required',
            'term' => [
                'required',
                Rule::unique('terms')
                    ->where(fn ($query) => $query->where('academic_year_id', $this->year_id))
                    ->ignore($this->route('id'), 'uuid') // ignore current term ID
            ],
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'next_term_start_date' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'term.unique' => 'This term already exists for the selected academic year.',
            'end_date.after' => 'The end date must be after the start date.',
        ];
    }

    public function withValidator($validator)
    {
        $companyId = company()->id;

        $year = app(AcademicYearRepository::class)
            ->company($companyId)
            ->fromCache()
            ->getYear($this->year_id);

        $validator->after(function ($validator) use ($year, $companyId) {
            // Rule 1: must fall within academic year
            if ($year) {
                if ($this->start_date < $year->start_date || $this->end_date > $year->end_date) {
                    $validator->errors()->add(
                        'start_date',
                        "The term dates must fall within the academic year ({$year->start_date} to {$year->end_date})."
                    );
                }
            }

            // Rule 2: must not overlap existing terms
            $overlap = Term::whereCompanyId($companyId)
                ->where('academic_year_id', $this->year_id)
                ->where('uuid', '!=', $this->route('id')) // exclude current term
                ->where(function ($query) {
                    $query->where('start_date', '<=', $this->end_date)
                          ->where('end_date', '>=', $this->start_date);
                })
                ->exists();

            if ($overlap) {
                $validator->errors()->add(
                    'date_range',
                    'The selected date range overlaps with an existing term.'
                );
            }
        });
    }
}