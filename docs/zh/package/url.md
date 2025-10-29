# Url

## 安装

```bash
composer require ghjayce/phparm-url
```

## Url

`\Ghjayce\Phparm\Url\Url` 继承于 `\Ghjayce\Phparm\Entity\Attribute`

### 概念

`http://username:password@hostname:9090/path?arg=value#anchor#abc`

- 基础URL：指 `http://username:password@hostname:9090` 部分。
- scheme：指 `http` 部分。
- user：指 `username` 部分。
- pass：指 `password` 部分。
- host：指 `hostname` 部分。
- port：指 `9090` 部分。
- path：指 `/path` 部分。
- query：指 `arg=value` 部分。
- fragment：指 `anchor#abc` 部分。

### 方法

| 方法           | 说明                                |
|:-------------|:----------------------------------|
| `parse()`    | 基于 `parse_url()` 解析 URL 字符串，返回数组。 |
| `base()`     | 返回基础 URL 字符串。                     |
| `baseSwap()` | 替换基础部分后的 URL 字符串。                 |

### 使用

```php
<?php

use Ghjayce\Phparm\Url\Url;

$url = 'http://username:password@hostname:9090/path?arg=value#anchor';
$instance = Url::make($url);
// 输出：http://username:password@hostname:9090
echo $instance->base();

// 输出：https://newhost:8080/abc/path?arg=value#anchor
echo $instance->baseSwap('https://newhost:8080/abc');
```

## Query

`\Ghjayce\Phparm\Url\Url` 继承于 `\Ghjayce\Phparm\Entity\StringValue`

### 方法

| 方法         | 说明                                     |
|:-----------|:---------------------------------------|
| `build()`  | 基于 `http_build_query()` 生成查询数组。        |
| `parse()`  | 基于 `parse_str()` 解析查询。                 |
| `append()` | 在原有 query 的基础上追加新的 query。              |
| `merge()`  | 合并 query 参数，新的 query 参数会覆盖旧的 query 参数。 |

### 使用

```php
<?php

use Ghjayce\Phparm\Url\Query;

$instance = Query::make('a=b&c=d')
    ->append('?e=f&a=aa');
// 输出：a=b&c=d&e=f&a=aa
echo $instance;

$instance = Query::make('a=b&c=d')
    ->merge(' ?e=f&a=aa ');
// 输出：a=aa&c=d&e=f
echo $instance;
```