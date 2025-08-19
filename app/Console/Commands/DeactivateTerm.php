<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\Term;

class DeactivateTerm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * {id : The ID or UUID of the term to deactivate}
     *
     * @var string
     */
    protected $signature = 'schoolviser:term:deactivate {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate a term by ID or UUID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');

        $term = Term::where('id', $id)->orWhere('uuid', $id)->first();

        if (!$term) {
            $this->error("No term found with ID/UUID: {$id}");
            return Command::FAILURE;
        }

        // Update status and is_current
        $term->status = 'inactive';
        $term->is_current = false;
        $term->save();

        $this->info("✅ Term [{$term->year} - {$term->term}] (ID: {$term->id}, UUID: {$term->uuid}) has been deactivated.");

        return Command::SUCCESS;
    }
}
