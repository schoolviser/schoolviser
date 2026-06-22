<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\Term;

class ShowTermsV2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * {--page=1 : The page number to display}
     * {--per-page=10 : Number of records per page}
     *
     * @var string
     */
    protected $signature = 'schoolviser2:show-terms {--page=1} {--per-page=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display terms in a table format with pagination';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $page = (int) $this->option('page');
        $perPage = (int) $this->option('per-page');

        $terms = Term::orderBy('year', 'desc')
            ->orderBy('term', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);

        if ($terms->isEmpty()) {
            $this->warn("No terms found on page {$page}.");
            return Command::SUCCESS;
        }

        $rows = $terms->map(function ($term) {
            return [
                'ID'        => $term->id,
                'UUID'      => $term->uuid,
                'Year'      => $term->year,
                'Term'      => $term->term,
                'Start'     => $term->start_date,
                'End'       => $term->end_date,
                'Status'    => $term->status ?? 'N/A',
                'IsCurrent' => $term->is_current ? 'Yes' : 'No',
                'Created'   => $term->created_at?->format('Y-m-d'),
            ];
        })->toArray();

        $this->table(
            ['ID', 'UUID', 'Year', 'Term', 'Start', 'End', 'Status', 'Is Current', 'Created At'],
            $rows
        );

        $this->info("Page {$terms->currentPage()} of {$terms->lastPage()} | Total: {$terms->total()} terms");

        return Command::SUCCESS;
    }
}
