<?php

if (! function_exists('slugify')) {
    /**
     * Generate a slug.
     */
    function slugify(string $value, int $randSize = 0): string {
        $value = str_slug($value);
        if ($randSize) {
            return $value . '-' . str_random($randSize);
        }
        return $value;
    }
}

if (! function_exists('generate_th_link')) {
    /**
     * Generate a link for table column sorting.
     */
    function generate_th_link(string $column): string {
        if (request('order', '') === $column) {
            $query = [
                'direction' => request('direction', '') === '' ? 'asc'
                    : request('direction') === 'asc' ? 'desc' : 'asc',
            ];
        } else {
            $query = [
                'order' => $column,
                'direction' => 'asc',
            ];
        }
        $url = request()->fullUrlWithQuery($query);
        $icon = $query['direction'] === 'asc' ? 'oi-arrow-thick-top' : 'oi-arrow-thick-bottom';
        $title = trans("global.sort_{$query['direction']}");
        
        return "<a title='{$title}' href='{$url}'>" . trans("book_lists.{$column}")
            . ' </a>' . '<span class="oi ' . $icon . '"></span>';
    }
}