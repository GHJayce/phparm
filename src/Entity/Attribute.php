<?php

declare(strict_types=1);

namespace GHJayce\Weapons\Entity;

use Traversable;

class Attribute implements \IteratorAggregate
{
    protected array $data = [];

    public static function make(): static
    {
        return new static;
    }

    public function get(string $var)
    {
        return $this->data[$var] ?? null;
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

    public function __call($methodName, array $args = [])
    {
        $offset = 0;
        $length = 3;
        $action = substr($methodName, $offset, $length);
        $attribute = lcfirst(substr($methodName, $length + $offset));
        switch ($action) {
            case 'get':
                return $this->$attribute ?? null;
            case 'set':
                $this->$attribute = $args[0];
                return $this;
        }
        throw new \Exception("unknown method name: {$methodName}");
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this);
    }
}
