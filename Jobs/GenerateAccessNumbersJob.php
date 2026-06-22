<?php

namespace Modules\Schoolviser\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;

use Modules\Schoolviser\Console\GenerateStudentAccessNumbers;

class GenerateAccessNumbersJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $companyId;

    public function __construct(int $companyId)
    {
        $this->companyId = $companyId;
    }

    public function uniqueId(): string
    {
        return 'gsan-'.$this->companyId;
    }

    public function handle()
    {
        // Call your command logic directly
        \Artisan::call('schoolviser:gsan', [
            'company' => $this->companyId,
        ]);
    }
}