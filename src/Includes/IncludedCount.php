<?php

namespace mPhpMaster\BuilderFilter\Includes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class IncludedCount implements IncludeInterface
{
    public function __invoke(Builder $query, string $count)
    {
        $query->withCount(Str::before($count, config('builder-filter.count_suffix')));
    }
}
