<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Generate an array of breadcrumb items.
     */
    public function getBreadcrumbFor(array $routeItems): array
    {
        $breadcrumb = [];
        foreach ($routeItems as $item) {
            $breadcrumb[] = [
                'url' => route($item['name'], $item['params'] ?? []),
                'text' => trans("global.breadcrumb.{$item['name']}"),
            ];
        }
        return $breadcrumb;
    }
}
