<?php

namespace Slartibax\TesttaskSitemapPhpPkg;

use ReflectionClass;

abstract class SitemapTag
{
    public function __construct(?array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getFields(): array
    {
        return get_object_vars($this);
    }

    public function getKey(): string
    {
        return strtolower((new ReflectionClass($this))->getShortName());
    }
}