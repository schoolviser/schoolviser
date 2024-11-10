<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Entities\Term;


class PopulateStudentSemesterTotal implements ShouldQueue
{
    use Queueable;

    public $semester;

    /**
     * Create a new job instance.
     */
    public function __construct($semester)
    {
        $this->semester = $semester;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->semester)
        {
            //Get Registrations
            $term = Term::whereId($this->semester)->with('termlyRegistrations')->first();

            if($term && count($term->termlyRegistrations) > 0){
                $term->setMeta('total_students', count($term->termlyRegistrations));
                $term->save();
            }

        }
    }
}
