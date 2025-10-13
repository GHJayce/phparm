<?php

declare(strict_types=1);

namespace Ghjayce\Phparm\Entity;

/**
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
     * @param string $attributes
     * @param array $options
     * @return $this
     */
    public function fill($attributes = null, array $options = []): static
    {
        $newAttributes = $this->transform($attributes);
        return parent::fill($newAttributes, $options);
    }

    /**
     * @param string $attributes
     * @param array $options
     * @return array|string[]
     */
    protected function transform(mixed $attributes = null, array $options = []): array
    {
        if (is_string($attributes)) {
            $attributes = [
                'value' => $attributes,
            ];
        }
        return $attributes;
    }
}