<?php

declare(strict_types=1);

namespace Ghjayce\Phparm\Entity;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @method string getValue()
 * @method self setValue(string $value)
 */
class StringValue extends Attribute
{
    public string $value;

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param null|Arrayable<TKey,TValue>|Jsonable|JsonSerializable|static<TKey,TValue> $attributes
     * @return array<TKey,TValue>
     */
    protected function transform($attributes, array $options = []): array
    {
        if (is_string($attributes)) {
            $attributes = [
                'value' => $attributes,
            ];
        }
        return parent::transform($attributes, $options);
    }
}