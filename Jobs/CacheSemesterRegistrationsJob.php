<?php

namespace Modules\Student\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use Modules\Student\Repositories\SemesterRegistrationRepository;


class CacheSemesterRegistrationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $semester;

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
        app(SemesterRegistrationRepository::class)->fromCache()->current()->getRegistrations();
    }
}
