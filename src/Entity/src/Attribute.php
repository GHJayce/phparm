<?php

namespace GHJayce\Weapon\Entity;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Traversable;

class Attribute implements \IteratorAggregate, Arrayable, Jsonable
{
    public static function make(): static
    {
        return new static;
    }

    public function fillProperty(array $properties): self
    {
        foreach ($properties as $property => $value) {
            if (!is_string($property) || !property_exists($this, $property)) {
                continue;
            }
            $this->$property = $value ?? null;
        }
        return $this;
    }

    protected function prefixActionMap(string $action): ?callable
    {
        return match ($action) {
            'get' => [$this, 'prefixActionGet'],
            'set' => [$this, 'prefixActionSet'],
            default => null,
        };
    }

    protected function prefixActionGet(string $attribute, string $methodName, array $args = []): mixed
    {
        $iterator = $this->getIterator();
        if (!$iterator->offsetExists($attribute)) {
            return null;
        }
        return $this->$attribute;
    }

    protected function prefixActionSet(string $attribute, string $methodName, array $args = []): static
    {
        $iterator = $this->getIterator();
        if (!$iterator->offsetExists($attribute)) {
            throw new \BadMethodCallException(sprintf('Property "%s" is not public or is not defined.', $attribute));
        }
        $this->$attribute = $args[0];
        return $this;
    }

    public function __call(string $methodName, array $args = []): mixed
    {
        $offset    = 0;
        $length    = 3;
        $action    = substr($methodName, $offset, $length);
        $attribute = lcfirst(substr($methodName, $length + $offset));
        $callable  = $this->prefixActionMap($action);
        if ($callable && is_callable($callable)) {
            return call_user_func($callable, $attribute, $methodName, $args);
        }
        throw new \BadMethodCallException('Unsupported operation');
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this);
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->getIterator() as $field => $value) {
            $result[$field] = $value;
        }
        return $result;
    }

    public function toJson($options = 0): string
    {
        $result = $this->toArray();
        return json_encode($result, $options);
    }
}
