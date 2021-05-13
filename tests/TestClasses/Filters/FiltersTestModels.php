<?php

namespace mPhpMaster\BuilderFilter\Tests\TestClasses\Filters;

use Illuminate\Database\Eloquent\Builder;
use mPhpMaster\BuilderFilter\Filters\Filter;

class FiltersTestModels implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->where($property, $value);
    }
}
