<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Entity;

/**
 * @method string getProtIucn()
 * @method self setProtIucn(string $iucn)
 * @method string getName()
 * @method self setName(string $name)
 */
class TigerOfIucn extends Tiger
{
    public const NO_PREFIX_METHOD_NAME = 'noPrefixMethod';
    public const NAME_HIDE_TIPS = '名字受保护暂不展示';

    protected function prefixMethodMap(): array
    {
        return array_merge(parent::prefixMethodMap(), [
            '' => [$this, self::NO_PREFIX_METHOD_NAME],
            'getProt' => [$this, 'prefixMethodGetProtect'],
            'setProt' => [$this, 'prefixMethodSetProtect'],
        ]);
    }

    protected function prefixMethodGet(string $attribute, array $args = [], array $options = []): mixed
    {
        if ($attribute === 'name') {
            return self::NAME_HIDE_TIPS;
        }
        return parent::prefixMethodGet($attribute, $args, $options);
    }

    protected function prefixMethodGetProtect(string $attribute, array $args = [], array $options = []): mixed
    {
        return $this->$attribute ?? null;
    }

    protected function prefixMethodSetProtect(string $attribute, array $args = [], array $options = []): static
    {
        if (isset($this->$attribute)) {
            $this->$attribute = $args[0] ?? null;
        }
        return $this;
    }

    protected function noPrefixMethod(string $attribute, array $args = [], array $options = []): string
    {
        return implode('_', [__FUNCTION__, $attribute]);
    }
}