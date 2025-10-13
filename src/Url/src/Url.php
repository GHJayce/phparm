<?php

declare(strict_types=1);

namespace Ghjayce\Phparm\Url;

use Ghjayce\Phparm\Entity\Attribute;
use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @method Query|null getQuery()
 * @method self setQuery(Query|null $query)
 */
class Url extends Attribute
{
    public string $scheme;
    public string $host;
    public int $port;
    public string $user;
    public string $pass;
    public string $path;
    public ?Query $query = null;
    public string $fragment;

    /**
     * @param Arrayable<TKey,TValue>|string $attributes
     * @param array $options
     */
    public function __construct($attributes, array $options = [])
    {
        parent::__construct($attributes, $options);
    }

    public function __toString(): string
    {
        return implode('', [
            $this->scheme ?: '',
            '://',
            $this->user ?: '',
            $this->pass ? ":{$this->pass}@" : '',
            $this->host ?: '',
            $this->port ? ":{$this->port}" : '',
            $this->path ?: '',
            $this->query?->getValue() ? sprintf('?%s', $this->query) : '',
            $this->fragment ? "#{$this->fragment}" : '',
        ]);
    }

    /**
     * @param array|string $attributes
     * @param array $options
     * @return static
     */
    public static function make($attributes = null, array $options = []): static
    {
        return parent::make($attributes, $options);
    }

    /**
     * @param Arrayable<TKey,TValue>|string $attributes
     * @param array $options
     * @return array
     */
    protected function transform($attributes, array $options = []): array
    {
        if (is_string($attributes)) {
            $attributes = $this->parse($attributes);
            if (isset($attributes['query'])) {
                $attributes['query'] = Query::make($attributes['query']);
            }
        }
        return parent::transform($attributes, $options);
    }

    public function base(): string
    {
        return implode('', [
            $this->scheme ?: '',
            '://',
            $this->user ?: '',
            $this->pass ? ":{$this->pass}@" : '',
            $this->host ?: '',
            $this->port ? ":{$this->port}" : '',
        ]);
    }

    public function swapBase(string $swapUrl): static
    {
        $urlInfo = $this->parse($swapUrl);
        $this->scheme = $urlInfo['scheme'] ?? '';
        $this->user = $urlInfo['user'] ?? '';
        $this->pass = $urlInfo['pass'] ?? '';
        $this->host = $urlInfo['host'] ?? '';
        $this->port = $urlInfo['port'] ?? 0;
        return $this;
    }

    protected function parse(string $url): array
    {
        if (!str_starts_with($url, 'http')) {
            throw new InvalidArgumentException('Invalid url');
        }
        return parse_url($url) ?: [];
    }
}