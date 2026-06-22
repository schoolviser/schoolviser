<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Delgont\Armor\Models\PageAccess;

class ShowPageViews extends Command
{
    protected $signature = 'show:page-views 
                            {page_name? : The name of the page to filter by}
                            {ip? : The IP address to filter by}
                            {--perPage=10 : Number of results per page}
                            {--sort=desc : Sort order (asc/desc)}';

    protected $description = 'Display the page views with optional filters and pagination';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        // Fetch input and options
        $pageName = $this->argument('page_name');
        $ip = $this->argument('ip');
        $perPage = max((int) $this->option('perPage'), 1); // Ensure perPage is at least 1
        $sortOrder = $this->option('sort');

        // Validate sortOrder
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $this->error('Invalid sort order. Please choose either "asc" or "desc".');
            return 1;
        }

        // Start building the query
        $query = PageAccess::query();

        // Apply filters
        if ($pageName) {
            $query->where('page_name', 'like', "%{$pageName}%");
        }

        if ($ip) {
            $query->where('ip', $ip);
        }

        // Apply sorting
        $query->orderBy('created_at', $sortOrder);

        // Paginate results
        $pageAccesses = $query->paginate($perPage);

        // Display results
        if ($pageAccesses->isEmpty()) {
            $this->info('No page views found for the given filters.');
        } else {
            $this->table(
                ['ID', 'Page Name', 'Page URL', 'IP Address', 'Count', 'User Agent', 'Date'],
                $pageAccesses->map(fn($pageAccess) => [
                    $pageAccess->id,
                    $pageAccess->page_name,
                    $pageAccess->page_url,
                    $pageAccess->ip,
                    $pageAccess->count,
                    Str::limit($pageAccess->user_agent, 30),
                    $pageAccess->created_at->toDateTimeString(),
                ])->toArray()
            );

            $this->info("Showing page views: {$pageAccesses->total()} results.");
        }

        return 0;
    }
}
