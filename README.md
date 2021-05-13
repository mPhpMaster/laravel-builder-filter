# Build Eloquent queries from API requests

This package allows you to filter, sort and include eloquent relations based on a request. The `QueryBuilder` used in this package extends Laravel's default Eloquent builder. This means all your favorite methods and macros are still available. Query parameter names follow the [JSON API specification](http://jsonapi.org/) as closely as possible.

## Basic usage

### Filter a query based on a request: `/users?filter[name]=John`:

```php
use mPhpMaster\BuilderFilter\QueryBuilder;

$users = QueryBuilder::for(User::class)
    ->allowedFilters('name')
    ->get();

// all `User`s that contain the string "John" in their name
```


### Including relations based on a request: `/users?include=posts`:

```php
$users = QueryBuilder::for(User::class)
    ->allowedIncludes('posts')
    ->get();

// all `User`s with their `posts` loaded
```


### Sorting a query based on a request: `/users?sort=id`:

```php
$users = QueryBuilder::for(User::class)
    ->allowedSorts('id')
    ->get();

// all `User`s sorted by ascending id
```


### Works together nicely with existing queries:

```php
$query = User::where('active', true);

$userQuery = QueryBuilder::for($query) // start from an existing Builder instance
    ->withTrashed() // use your existing scopes
    ->allowedIncludes('posts', 'permissions')
    ->where('score', '>', 42); // chain on any of Laravel's query builder methods
```

### Selecting fields for a query: `/users?fields[users]=id,email`

```php
$users = QueryBuilder::for(User::class)
    ->allowedFields(['id', 'email'])
    ->get();

// the fetched `User`s will only have their id & email set
```


### Appending attributes to a query: `/users?append=full_name`

```php
$users = QueryBuilder::for(User::class)
    ->allowedAppends('full_name')
    ->get()
    ->toJson();

// the resulting JSON will have the `getFullNameAttribute` attributes included
```


## Installation

You can install the package via composer:

```bash
composer require mphpmaster/laravel-builder-filter
```

## Documentation

Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improving the media library? Feel free to [create an issue on GitHub](https://github.com/mphpmaster/laravel-builder-filter/issues), we'll try to address it as soon as possible.

If you've found a bug regarding security please mail [mPhpMaster@gmail.com](mailto:mPhpMaster@gmail.com) instead of using the issue tracker.

### Upgrading

Please see [UPGRADING.md](UPGRADING.md) for details.

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mphpmaster@gmail.com instead of using the issue tracker.

## Credits

- [Alex Vanderbist](https://github.com/AlexVanderbist)
- [All Contributors](../../contributors)
- [mPhpMaster](https://github.com/mPhpMaster)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
