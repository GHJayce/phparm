<?php

declare(strict_types=1);

namespace Ghjayce\Phparm\Entity;

use ArrayIterator;
use BadMethodCallException;
use Ghjayce\Phparm\Entity\Traits\PrefixMethod;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonException;
use JsonSerializable;
use Stringable;

/**
 * @template TKey of array-key
 * @template TValue
 */
class Attribute implements IteratorAggregate, Arrayable, Jsonable, Stringable, JsonSerializable
{
    use PrefixMethod;

    /**
     * @param null|Arrayable<TKey,TValue>|Jsonable|JsonSerializable|static<TKey,TValue> $attributes
     * @param array $options
     * @throws JsonException
     */
    public function __construct($attributes = null, array $options = [])
    {
        $this->fill($attributes, $options);
    }

    public function __call(string $methodName, array $args = []): mixed
    {
        $prefixResult = $this->prefixMethod($methodName, $args);
        if ($prefixResult && is_array($prefixResult)) {
            return call_user_func(...$prefixResult);
        }
        throw new BadMethodCallException('Unsupported operation');
    }

    public function __toString(): string
    {
        return serialize($this->all());
    }

    /**
     * @param null|Arrayable<TKey,TValue>|Jsonable|JsonSerializable|static<TKey,TValue> $attributes
     * @return array<TKey,TValue>
     * @throws JsonException
     */
    protected function transform($attributes): array
    {
        if (is_null($attributes)) {
            return [];
        }
        if (is_array($attributes)) {
            return $attributes;
        }
        if ($attributes instanceof static) {
            return $attributes->all();
        }
        if ($attributes instanceof Arrayable) {
            return $attributes->toArray();
        }
        if ($attributes instanceof Jsonable) {
            return json_decode($attributes->toJson(), true);
        }
        if ($attributes instanceof JsonSerializable) {
            return $attributes->jsonSerialize();
        }
        return (array)$attributes;
    }

    /**
     * @param null|Arrayable<TKey,TValue>|Jsonable|JsonSerializable|static<TKey,TValue> $attributes
     * @param array $options
     * @return $this
     * @throws JsonException
     */
    public static function make($attributes = null, array $options = []): static
    {
        return new static($attributes, $options);
    }

    /**
     * @param null|Arrayable<TKey,TValue>|Jsonable|JsonSerializable|static<TKey,TValue> $attributes
     * @param array $options
     * @return $this
     * @throws JsonException
     */
    public function fill($attributes = null, array $options = []): static
    {
        $data = $this->transform($attributes);
        $iterator = $this->getIterator();
        foreach ($data as $attribute => $value) {
            if (
                (
                    !is_string($attribute)
                    && !is_int($attribute)
                )
                || !$iterator->offsetExists($attribute)
            ) {
                continue;
            }
            $this->$attribute = $value;
        }
        return $this;
    }

    protected function prefixMethodMap(): array
    {
        return [
            'get' => [$this, 'prefixMethodGet'],
            'set' => [$this, 'prefixMethodSet'],
        ];
    }

    protected function prefixMethodGet(string $attribute, array $args = [], array $options = []): mixed
    {
        $iterator = $this->getIterator();
        if (!$iterator->offsetExists($attribute)) {
            return null;
        }
        return $this->$attribute;
    }

    protected function prefixMethodSet(string $attribute, array $args = [], array $options = []): static
    {
        $iterator = $this->getIterator();
        if (!$iterator->offsetExists($attribute)) {
            throw new BadMethodCallException(sprintf('Property "%s" is not public or is not defined.', $attribute));
        }
        $this->$attribute = $args[0];
        return $this;
    }

    /**
     * @return ArrayIterator<TKey, TValue>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this);
    }

    /**
     * @return array<TKey, TValue>
     */
    public function all(): array
    {
        $result = [];
        foreach ($this->getIterator() as $field => $value) {
            $result[$field] = $value;
        }
        return $result;
    }

    /**
     * @return array<TKey, mixed>
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->getIterator() as $field => $value) {
            $finalValue = $value;
            if ($value instanceof Arrayable) {
                $finalValue = $value->toArray();
            }
            $result[$field] = $finalValue;
        }
        return $result;
    }

    public function toJson($options = JSON_THROW_ON_ERROR): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @return array<TKey, mixed>
     * @throws JsonException
     */
    public function jsonSerialize(): array
    {
        return array_map(static function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            }
            if ($value instanceof Jsonable) {
                return json_decode($value->toJson(), true, 512, JSON_THROW_ON_ERROR);
            }
            if ($value instanceof Arrayable) {
                return $value->toArray();
            }
            return $value;
        }, (array)$this->getIterator());
    }
}