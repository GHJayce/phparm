<?php

declare(strict_types=1);

namespace GhjayceTest\Weapon\Entity;

class MicroComputer extends Computer
{
    protected function prefixMethodMap(): array
    {
        return array_merge(parent::prefixMethodMap(), [
            '' => [$this, 'emptyPrefixMethod'],
            'getProtect' => [$this, 'prefixMethodGetProtect'],
        ]);
    }

    protected function emptyPrefixMethod(string $attribute, array $args = [], array $options = []): string
    {
        return implode(',', [__FUNCTION__, $attribute]);
    }
}
