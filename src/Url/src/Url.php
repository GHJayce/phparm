<?php

declare(strict_types=1);

namespace Ghjayce\Phparm\Url;

use Ghjayce\Phparm\Entity\Attribute;

/**
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

    public function __construct(array|string $attributes, array $options = [])
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
    public static function make(mixed $attributes = null, array $options = []): static
    {
        return parent::make($attributes, $options);
    }

    /**
     * @param array|string $attributes
     * @param array $options
     * @return $this
     */
    public function fill($attributes = null, array $options = []): static
    {
        if (is_string($attributes)) {
            $attributes = $this->parse($attributes);
            if (isset($attributes['query'])) {
                $attributes['query'] = Query::make($attributes['query']);
            }
        }
        return parent::fill($attributes, $options);
    }

    public function baseUrl(): string
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

    public function swapBaseUrl(string $replaceUrl): static
    {
        $urlInfo = $this->parse($replaceUrl);
        return self::make(array_merge($this->all(), $urlInfo));
    }

    protected function parse(string $url): array
    {
        if (!str_starts_with($url, 'http')) {
            throw new \InvalidArgumentException('Invalid url');
        }
        return parse_url($url) ?: [];
    }
}