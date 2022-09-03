<?php

namespace App\Nova\Filters;

use App\Models\Menu;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class MenuByParent extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest|Request $request, $query, $value)
    {
        if ($value === 0) {
            return $query->whereNull('parent_id');
        }

        return $query->where('parent_id', $value);
    }

    public function default(): int
    {
        return 0;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(NovaRequest|Request $request)
    {
        $parents = Menu::query()
            ->whereHas('children')
            ->get(['id', 'name']);

        return array_combine($parents->pluck('name')->toArray(), $parents->pluck('id')->toArray());
    }
}
