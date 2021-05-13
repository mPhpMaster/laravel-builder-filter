# Upgrading

Because there are many breaking changes an upgrade is not that easy. There are many edge cases this guide does not cover. We accept PRs to improve this guide.

## From v2 to v3

Possible changes in this version due to internal changes.

The package's `mPhpMaster\BuilderFilter\QueryBuilder` class no longer extends Laravel's `Illuminate\Database\Eloquent\Builder`. This means you can no longer pass a `QueryBuilder` instance where a `Illuminate\Database\Eloquent\Builder` instance is expected. However, all Eloquent method calls get forwarded to the internal `Illuminate\Database\Eloquent\Builder`.

Using `$queryBuilder->getEloquentBuilder()` you can access the internal `Illuminate\Database\Eloquent\Builder`.

## From v1 to v2

There are a lot of renamed methods and classes in this release. An advanced IDE like PhpStorm is recommended to rename these methods and classes in your code base. Use the refactor -> rename functionality instead of find & replace.

- rename `mPhpMaster\BuilderFilter\Sort` to `mPhpMaster\BuilderFilter\AllowedSort`
- rename `mPhpMaster\BuilderFilter\Included` to `mPhpMaster\BuilderFilter\AllowedInclude`
- rename `mPhpMaster\BuilderFilter\Filter` to `mPhpMaster\BuilderFilter\AllowedFilter`
- replace request macro's like `request()->filters()`, `request()->includes()`, etc... with their related methods on the `BuilderFilterRequest` class. This class needs to be instantiated with a request object, (more info here: https://github.com/mphpmaster/laravel-builder-filter/issues/328):
    * `request()->includes()` -> `BuilderFilterRequest::fromRequest($request)->includes()`
    * `request()->filters()` -> `BuilderFilterRequest::fromRequest($request)->filters()`
    * `request()->sorts()` -> `BuilderFilterRequest::fromRequest($request)->sorts()`
    * `request()->fields()` -> `BuilderFilterRequest::fromRequest($request)->fields()`
    * `request()->appends()` -> `BuilderFilterRequest::fromRequest($request)->appends()`
- please note that the above methods on `BuilderFilterRequest` do not take any arguments. You can use the `contains` to check for a certain filter/include/sort/...
- make sure the second argument for `AllowedSort::custom()` is an instance of a sort class, not a classname
    * `AllowedSort::custom('name', MySort::class)` -> `AllowedSort::custom('name', new MySort())`
- make sure the second argument for `AllowedFilter::custom()` is an instance of a filter class, not a classname
    * `AllowedFilter::custom('name', MyFilter::class)` -> `AllowedFilter::custom('name', new MyFilter())`
- make sure all required sorts are allowed using `allowedSorts()`
- make sure all required field selects are allowed using `allowedFields()`
- make sure `allowedFields()` is always called before `allowedIncludes()`
