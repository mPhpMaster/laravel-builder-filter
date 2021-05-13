---
title: Multi value delimiter
weight: 4
---

Sometimes values to filter for could include commas. This is why you can specify the delimiter symbol using the `BuilderFilterRequest` to overwrite the default behaviour.

```php
// GET /api/endpoint?filter=12,4V|4,7V|2,1V

BuilderFilterRequest::setArrayValueDelimiter('|');

QueryBuilder::for(Model::class)
    ->allowedFilters(AllowedFilter::exact('voltage'))
    ->get();

// filters: [ 'voltage' => [ '12,4V', '4,7V', '2,1V' ]]
```

__Note that this applies to ALL values for filters, includes and sorts__

## Usage 

There are multiple opportunities where the delimiter can be set.

You can define it in a `ServiceProvider` to apply it globally, or define a middleware that can be applied only on certain `Controllers`.
```php
// YourServiceProvider.php
public function boot() {
    BuilderFilterRequest::setArrayDelimiter(';');
}

// ApplySemicolonDelimiterMiddleware.php
public function handle($request, $next) {
    BuilderFilterRequest::setArrayDelimiter(';');
    return $next($request);
}
```

You can also set the delimiter for each feature individually:
```php
BuilderFilterRequest::setIncludesArrayValueDelimiter(';'); // Includes
BuilderFilterRequest::setAppendsArrayValueDelimiter(';');  // Appends
BuilderFilterRequest::setFieldsArrayValueDelimiter(';');   // Fields
BuilderFilterRequest::setSortsArrayValueDelimiter(';');    // Sorts
BuilderFilterRequest::setFilterArrayValueDelimiter(';');   // Filter
```

You can override the default delimiter for single filters:
```php
// GET /api/endpoint?filter[id]=h4S4MG3(+>azv4z/I<o>,>XZII/Q1On
AllowedFilter::exact('id', 'ref_id', true, ';');
```
