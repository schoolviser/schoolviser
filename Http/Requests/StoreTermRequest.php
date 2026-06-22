<?php

namespace Modules\Schoolviser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Schoolviser\Repositories\AcademicYearRepository;

class StoreTermRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Adjust if you want to restrict who can create terms
        return true;
    }

    public function rules(): array
    {
        $companyId = company()->id;
        $max_end_date = \Modules\Schoolviser\Entities\Term::whereCompanyId($companyId)->max('end_date') ?? '2007-01-01';

        return [
            'year_id' => 'required',
            'term' => [
                'required',
                Rule::unique('terms')
                    ->where(fn ($query) => $query->where('academic_year_id', $this->year_id))
            ],
            'start_date' => 'required|date|after_or_equal:' . $max_end_date,
            'end_date'   => 'required|date|after:start_date',
            'next_term_start_date' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => "There is already a session between {$this->start_date} and {$this->max_end_date}",
            'term.unique' => 'This term already exists for the selected academic year.',
        ];
    }

    public function withValidator($validator)
    {
        $year = app(AcademicYearRepository::class)
            ->company(company()->id)
            ->fromCache()
            ->getYear($this->year_id);

        $validator->after(function ($validator) use ($year) {
            if ($year) {
                if ($this->start_date < $year->start_date || $this->end_date > $year->end_date) {
                    $validator->errors()->add(
                        'start_date',
                        "The term dates must fall within the academic year ({$year->start_date} to {$year->end_date})."
                    );
                }
            }
        });
    }
}