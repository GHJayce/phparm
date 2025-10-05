<?php

declare(strict_types=1);

namespace GhjayceTest\Weapon\Entity;

use Ghjayce\Weapon\Entity\Attribute;

/**
 * @method string getCpu()
 * @method self setCpu(string $cpu)
 * @method string getAbc()
 * @method string getProtectBiosVersion()
 */
class Computer extends Attribute
{
    public string $cpu;
    public string $gpu;
    public string $mainBoard;
    public array $memoryBank;
    public array $hardDisk;
    protected int $biosVersion = 10000;
    public ?Power $power = null;

    protected function prefixMethodGet(string $attribute, array $args = [], array $options = []): mixed
    {
        $methodName = $options['methodName'] ?? null;
        if ($methodName === 'getAbc') {
            return $methodName;
        }
        return parent::prefixMethodGet($attribute, $args, $options);
    }

    protected function prefixMethodMap(): array
    {
        return array_merge(parent::prefixMethodMap(), [
            'getProtect' => [$this, 'prefixMethodGetProtect'],
        ]);
    }

    protected function prefixMethodGetProtect(string $attribute, array $args = [], array $options = []): mixed
    {
        return $this->$attribute ?? null;
    }

    protected function emptyPrefixMethod(string $attribute, array $args = [], array $options = []): string
    {
        return implode(',', [__FUNCTION__, $attribute]);
    }
}
