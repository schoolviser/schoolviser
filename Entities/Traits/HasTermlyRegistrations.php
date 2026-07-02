<?php

namespace Modules\Schoolviser\Entities\Traits;

use Modules\Schoolviser\Entities\TermlyRegistration;

trait HasTermlyRegistrations
{

    public function termlyRegistration($termId)
    {
        return $this->hasOne(TermlyRegistration::class, 'student_id')->where('term_id', $termId);
    }

    /**
     * All termly registrations for the student.
     */
    public function termlyRegistrations()
    {
        return $this->hasMany(TermlyRegistration::class, 'student_id');
    }

    /**
     * Current term registration.
     */
    public function currentTermlyRegistration()
    {
        return $this->hasOne(TermlyRegistration::class, 'student_id')
            ->whereHas('term', fn($q) => $q->current());
    }

    /**
     * Previous term registration.
     */
    public function previousTermlyRegistration()
    {
        return $this->hasOne(TermlyRegistration::class, 'student_id')
            ->whereHas('term', fn($q) => $q->previous());
    }

    /**
     * Promote student to next class.
     */
    public function promote($term, $nextClazzId, $nextStreamId = null)
    {
        return $this->termlyRegistrations()->create([
            'term_id' => $term->id,
            'clazz_id' => $nextClazzId,
            'stream_id' => $nextStreamId,
            'student_id' => $this->id,
            'company_id' => $this->company_id,
            'new_or_continuing' => 'continuing',
        ]);
    }

    /**
     * Demote student to a lower class.
     */
    public function demote($term, $clazzId, $streamId = null)
    {
        return $this->termlyRegistrations()->create([
            'term_id' => $term->id,
            'clazz_id' => $clazzId,
            'stream_id' => $streamId,
            'student_id' => $this->id,
            'company_id' => $this->company_id,
            'new_or_continuing' => 'continuing',
            'meta' => json_encode(['demoted' => true]),
        ]);
    }

    /**
     * Change stream within the same class and term.
     */
    public function changeStream($term, $newStreamId)
    {
        $registration = $this->termlyRegistrations()->where('term_id', $term->id)->first();
        if ($registration && !$registration->locked) {
            $registration->update(['stream_id' => $newStreamId]);
        }
        return $registration;
    }

    /**
     * Lock student’s registration for a term.
     */
    public function lockRegistration($term)
    {
        $registration = $this->termlyRegistrations()->where('term_id', $term->id)->first();
        if ($registration) $registration->update(['locked' => true]);
    }

    /**
     * Unlock student’s registration for a term.
     */
    public function unlockRegistration($term)
    {
        $registration = $this->termlyRegistrations()->where('term_id', $term->id)->first();
        if ($registration) $registration->update(['locked' => false]);
    }

    /**
     * Scope: currently enrolled students.
     */
    public function scopeCurrent($query)
    {
        return $query->whereHas('currentTermlyRegistration');
    }
}
