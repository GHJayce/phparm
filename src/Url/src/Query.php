<?php

declare(strict_types=1);

namespace Ghjayce\Phparm\Url;

use Ghjayce\Phparm\Entity\StringValue;
use Illuminate\Contracts\Support\Arrayable;

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
     * @param array $options
     * @return array
     */
    protected function transform($attributes, array $options = []): array
    {
        if (is_array($attributes)) {
            $attributes = [
                'value' => $this->build($attributes),
            ];
        }
        return parent::transform($attributes, $options);
    }

    public function build(array|object $query, array $options = []): string
    {
        return http_build_query(
            $query,
            $options['numericPrefix'] ?? '',
            $options['argSeparator'] ?? null,
            $options['encodingType'] ?? PHP_QUERY_RFC3986
        );
    }

    public function parse(?string $query = null): ?array
    {
        $needle = $query;
        if (is_null($query)) {
            $needle = $this->value;
        }
        if (is_null($needle)) {
            return null;
        }
        if (!trim($needle)) {
            return [];
        }
        $result = [];
        parse_str($needle, $result);
        return $result;
    }

    public function append(array|string $query = [], array $options = []): static
    {
        if (!$query) {
            return $this;
        }
        if (is_array($query)) {
            $query = $this->build($query, $options);
        }
        if (isset($this->value)) {
            $this->value .= $query ? "&{$query}" : '';
        }
        return $this;
    }

    public function merge(array|string $query = [], array $options = []): static
    {
        if (!$query) {
            return $this;
        }
        $newQuery = $query;
        if (is_string($query)) {
            $newQuery = $this->parse($query) ?: [];
        }
        $this->value = $this->build(array_merge($this->toArray(), $newQuery), $options);
        return $this;
    }

    public function toArray(): array
    {
        return $this->parse($this->value);
    }
}