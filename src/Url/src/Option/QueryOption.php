<?php

declare(strict_types=1);

namespace Ghjayce\Phparm\Url\Option;

use Ghjayce\Phparm\Entity\Option;

/**
 * @method string getNumericPrefix()
 * @method self setNumericPrefix(string $numericPrefix)
 * @method string|null getArgSeparator()
 * @method self setArgSeparator(string|null $argSeparator)
 * @method int getEncodingType()
 * @method self setEncodingType(int $encodingType)
 */
class QueryOption extends Option
{
    public string $numericPrefix = '';
    public ?string $argSeparator = null;
    public int $encodingType = PHP_QUERY_RFC3986;
}