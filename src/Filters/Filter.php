<?php

namespace mPhpMaster\BuilderFilter\Filters;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    public function __invoke(Builder $query, $value, string $property);
}
