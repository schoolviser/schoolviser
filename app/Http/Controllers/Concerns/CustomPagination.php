<?php

namespace App\Http\Controllers\Concerns;
use App\Support\Models\Any;

trait CustomPagination
{
    public function pagination($resource)
    {
        return new Any([
            'path' => $resource->path(),
            'current_page' => $resource->currentPage(),
            'prev_page_url' => $resource->previousPageUrl(),
            'next_page_url' => $resource->nextPageUrl(),
            'per_page' => $resource->perPage(),
            'total' => $resource->total(),
            'has_pages' => $resource->hasPages(),
            'last_page' => $resource->lastPage(),
            'page_name' => $resource->getPageName(),
        ]);
    }
}
