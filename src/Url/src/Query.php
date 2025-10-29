<?php

declare(strict_types=1);

namespace Ghjayce\PhparmUrl;

use Ghjayce\PhparmEntity\Option;
use Ghjayce\PhparmEntity\StringValue;
use Ghjayce\PhparmUrl\Option\QueryOption;
use Illuminate\Contracts\Support\Arrayable;

use function \http_build_query, \parse_str;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @method string getValue()
 * @method self setValue(string $value)
 */
class Query extends StringValue
{
    /**
     * @param Arrayable<TKey,TValue>|string $attributes
     * @param QueryOption|null $option
     * @return array
     */
    protected function transform($attributes, ?Option $option = null): array
    {
        $data = $attributes;
        if (is_array($data)) {
            $data = [
                'value' => $this->build($attributes, $option),
            ];
        } elseif (is_string($data)) {
            $data = $this->purge($data);
        }
        return parent::transform($data, $option);
    }

    public function build(array|object $query, ?QueryOption $option = null): string
    {
        return http_build_query(
            $query,
            $option ? $option->getNumericPrefix() : '',
            $option?->getArgSeparator(),
            $option ? $option->getEncodingType() : PHP_QUERY_RFC3986
        );
    }

    protected function purge(?string $query = null): string
    {
        if (is_null($query)) {
            return '';
        }
        $query = trim($query);
        if (str_starts_with($query, '?')) {
            $query = substr($query, 1);
            if (strrpos($query, '#') !== false) {
                $query = strstr($query, '#', true);
            }
        }
        return $query;
    }

    public function parse(?string $query = null): array
    {
        $needle = $this->purge($query);
        if (!$needle) {
            return [];
        }
        $result = [];
        parse_str($needle, $result);
        return $result;
    }

    public function append(array|string $query = [], ?QueryOption $option = null): static
    {
        if (!$query) {
            return $this;
        }
        if (is_array($query)) {
            $query = $this->build($query, $option);
        } elseif (is_string($query)) {
            $query = $this->purge($query);
        }
        if (isset($this->value)) {
            $this->value .= $query ? "&{$query}" : '';
        }
        return $this;
    }

    public function merge(array|string $query = [], ?QueryOption $option = null): static
    {
        if (!$query) {
            return $this;
        }
        $newQuery = $query;
        if (is_string($query)) {
            $newQuery = $this->parse($query);
        }
        $this->value = $this->build(array_merge($this->toArray(), $newQuery), $option);
        return $this;
    }

    public function toArray(): array
    {
        return $this->parse($this->value);
    }
}