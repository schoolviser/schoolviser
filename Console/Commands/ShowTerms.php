<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\TermRepository;

class ShowTerms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:show-terms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display a table of school terms';

    /**
     * The Term Repository instance.
     *
     * @var TermRepository
     */
    protected $termRepository;

    /**
     * Create a new command instance.
     *
     * @param TermRepository $termRepository
     */
    public function __construct(TermRepository $termRepository)
    {
        parent::__construct();
        $this->termRepository = $termRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch all terms
        $terms = $this->termRepository->all();

        if ($terms->isEmpty()) {
            $this->warn('No terms found.');
            return Command::SUCCESS;
        }

        // Get intakes configuration if school type is tertiary
        $intakes = config('schoolviser.type') === 'tertiary' ? config('schoolviser.intakes') : [];

        // Map terms to a table-friendly format
        $rows = $terms->map(function ($term) use ($intakes) {
            return [
                'ID' => $term->id,
                'UUID' => $term->uuid,
                'Term' => $intakes[$term->term] ?? 'Unknown Term', // Fetch from config or show fallback
                'Year' => $term->year,
                'Start Date' => \Carbon\Carbon::parse($term->start_date)->format('F j, Y'), // Format date
                'End Date' => \Carbon\Carbon::parse($term->end_date)->format('F j, Y'),   // Format date
                'Current' => $term->is_current ? 'Yes' : 'No',
            ];
        });

        // Display terms in a table
        $this->table(['ID', 'UUID', 'Term', 'Year', 'Start Date', 'End Date', 'Current'], $rows);

        return Command::SUCCESS;
    }
}
