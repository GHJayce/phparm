
# Url

## Installation

```bash
composer require ghjayce/phparm-url
```

## Url

`\Ghjayce\Phparm\Url\Url` extends `\Ghjayce\Phparm\Entity\Attribute`

### Concepts

`http://username:password@hostname:9090/path?arg=value#anchor#abc`

- Base URL: Refers to the `http://username:password@hostname:9090` part.
- scheme: Refers to the `http` part.
- user: Refers to the `username` part.
- pass: Refers to the `password` part.
- host: Refers to the `hostname` part.
- port: Refers to the `9090` part.
- path: Refers to the `/path` part.
- query: Refers to the `arg=value` part.
- fragment: Refers to the `anchor#abc` part.

### Methods

| Method         | Description                                              |
|:--------------|:---------------------------------------------------------|
| `parse()`     | Parses a URL string based on `parse_url()`, returns array.|
| `base()`      | Returns the base URL string.                             |
| `baseSwap()`  | Returns the URL string after replacing the base part.    |

### Usage

```php
<?php

use Ghjayce\Phparm\Url\Url;

$url = 'http://username:password@hostname:9090/path?arg=value#anchor';
$instance = Url::make($url);
// Output: http://username:password@hostname:9090
echo $instance->base();

// Output: https://newhost:8080/abc/path?arg=value#anchor
echo $instance->baseSwap('https://newhost:8080/abc');
```

## Query

`\Ghjayce\Phparm\Url\Url` extends `\Ghjayce\Phparm\Entity\StringValue`

### Methods

| Method       | Description                                                        |
|:------------|:--------------------------------------------------------------------|
| `build()`   | Builds a query array based on `http_build_query()`.                 |
| `parse()`   | Parses a query string based on `parse_str()`.                       |
| `append()`  | Appends new query parameters to the original query.                 |
| `merge()`   | Merges query parameters, new parameters will overwrite the old ones. |

### Usage

```php
<?php

use Ghjayce\Phparm\Url\Query;

$instance = Query::make('a=b&c=d')
    ->append('?e=f&a=aa');
// Output: a=b&c=d&e=f&a=aa
echo $instance;

$instance = Query::make('a=b&c=d')
    ->merge(' ?e=f&a=aa ');
// Output: a=aa&c=d&e=f
echo $instance;
```
