<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stream extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * A stream belongs to a class.
     */
    public function clazz()
    {
        return $this->belongsTo(Clazz::class, 'clazz_id');
    }

    /**
     * A stream has many termly registrations.
     */
    public function termlyRegistrations()
    {
        return $this->hasMany(TermlyRegistration::class, 'stream_id');
    }

    /**
     * Get all students in this stream for a given term.
     */
    public function studentsOfTerm($termId)
    {
        return $this->termlyRegistrations()
            ->where('term_id', $termId)
            ->with('student')
            ->get()
            ->pluck('student');
    }

    /**
     * Count students in this stream for a given term.
     */
    public function countStudents($termId)
    {
        return $this->termlyRegistrations()
            ->where('term_id', $termId)
            ->count();
    }

    /**
     * Activate the stream.
     */
    public function activate()
    {
        return $this->update(['active' => true]);
    }

    /**
     * Deactivate the stream.
     */
    public function deactivate()
    {
        return $this->update(['active' => false]);
    }

    /**
     * Scope: only active streams.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope: streams of a given class.
     */
    public function scopeOfClazz($query, $clazzId)
    {
        return $query->where('clazz_id', $clazzId);
    }
}
