<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Entity;

use Ghjayce\Phparm\Entity\Option;

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

    protected function prefixMethodGet(string $attribute, string $methodName, array $args = [], ?Option $option = null): mixed
    {
        if ($attribute === 'name') {
            return self::NAME_HIDE_TIPS;
        }
        return parent::prefixMethodGet($attribute, $methodName, $args, $option);
    }

    protected function prefixMethodGetProtect(string $attribute, string $methodName, array $args = [], ?Option $option = null): mixed
    {
        return $this->$attribute ?? null;
    }

    protected function prefixMethodSetProtect(string $attribute, string $methodName, array $args = [], ?Option $option = null): static
    {
        if (isset($this->$attribute)) {
            $this->$attribute = $args[0] ?? null;
        }
        return $this;
    }

    protected function noPrefixMethod(string $attribute, string $methodName, array $args = [], ?Option $option = null): string
    {
        return implode('_', [__FUNCTION__, $attribute]);
    }
}