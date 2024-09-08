<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Tags;

use Slartibax\TesttaskSitemapPhpPkg\SitemapTag;

class Url extends SitemapTag
{
    protected string|null $loc;
    protected string|null $lastmod;
    protected string|null $priority;
    protected string|null $changefreq;

    public function __construct(?array $data)
    {
        $this->loc = $data['loc'] ?? null;
        $this->lastmod = $data['lastmod'] ?? null;
        $this->priority = $data['priority'] ?? null;
        $this->changefreq = $data['changefreq'] ?? null;
    }

    /**
     * @param string $changefreq
     */
    public function setChangefreq(string $changefreq): self
    {
        $this->changefreq = $changefreq;
        return $this;
    }

    public function setLoc(string $loc): self
    {
        $this->loc = $loc;
        return $this;
    }

    public function setLastmod(string $lastmod): self
    {
        $this->lastmod = $lastmod;
        return $this;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;
        return $this;
    }
}