<?php

declare(strict_types = 1);

namespace Ghjayce\Weapon\Entity;

use Ghjayce\Weapon\Entity\Traits\PrefixMethod;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Attribute implements \IteratorAggregate, Arrayable, Jsonable
{
    use PrefixMethod;

    public function __construct(array $attributes = [], array $options = [])
    {
        $this->fill($attributes, $options);
    }

    public function __call(string $methodName, array $args = []): mixed
    {
        $prefixResult = $this->prefixMethod($methodName, $args);
        if ($prefixResult && is_array($prefixResult)) {
            return call_user_func(...$prefixResult);
        }
        throw new \BadMethodCallException('Unsupported operation');
    }

    public static function make(array $attributes = [], array $options = []): static
    {
        return new static($attributes, $options);
    }

    public function fill(array $attributes, array $options = []): static
    {
        if (!$attributes) {
            return $this;
        }
        $iterator = $this->getIterator();
        foreach ($attributes as $attribute => $value) {
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
            throw new \BadMethodCallException(sprintf('Property "%s" is not public or is not defined.', $attribute));
        }
        $this->$attribute = $args[0];
        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this);
    }

    public function all(): array
    {
        $result = [];
        foreach ($this->getIterator() as $field => $value) {
            $result[$field] = $value;
        }
        return $result;
    }

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
        $result = [];
        foreach ($this->getIterator() as $field => $value) {
            $finalValue = $value;
            if ($value instanceof Jsonable) {
                $finalValue = $value->toJson();
                if ($value instanceof Arrayable) {
                    $finalValue = $value->toArray();
                }
            }
            $result[$field] = $finalValue;
        }
        return json_encode($result, $options);
    }
}
