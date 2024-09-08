<?php

namespace Slartibax\TesttaskSitemapPhpPkg;

interface SitemapGenerator
{
    public function __construct($fileHandle);

    public function initialize(): void;

    public function processTag(SitemapTag $tag): void;

    public function finalize(): void;
}