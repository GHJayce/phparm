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
     * @param null|Arrayable<TKey,TValue>|Jsonable|JsonSerializable|static<TKey,TValue>|string $attributes
     * @return array<TKey,TValue>
     * @throws \JsonException
     */
    protected function transform($attributes, array $options = []): array
    {
        $data = $attributes;
        if (is_string($data)) {
            $data = [
                'value' => $attributes,
            ];
        }
        return parent::transform($data, $options);
    }
}