<?php

declare(strict_types=1);

namespace Ghjayce\Phparm\Entity\Traits;

use Ghjayce\Phparm\Entity\Option;

trait PrefixMethod
{
    protected function prefixMethod(string $methodName, array $args = [], int $offset = 0, ?Option $option = null): ?array
    {
        $map = array_reverse($this->prefixMethodMap());
        if (isset($map[''])) {
            $emptyPrefixMethod = $map[''];
            unset($map['']);
            $map[''] = $emptyPrefixMethod;
        }
        foreach ($map as $prefix => $callable) {
            $isMatch = $prefix === '';
            $attribute = $methodName;
            if ($prefix) {
                $prefixLength = strlen($prefix);
                $action = substr($methodName, $offset, $prefixLength);
                $isMatch = $action === $prefix;
                $attribute = lcfirst(substr($methodName, $prefixLength + $offset));
            }
            if ($isMatch && $callable && is_callable($callable)) {
                return [$callable, $attribute, $methodName, $args, $option];
            }
        }
        return null;
    }
}