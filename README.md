
[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](LICENSE)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/slartibax/testtask-sitemap-php-pkg.svg?style=flat-square)](https://packagist.org/packages/slartibax/testtask-sitemap-php-pkg)

Тестовое задание для Пиробайта.

- Библиотека поддерживает только тэги url из массива urlset

Test script 

```
<?php

use Slartibax\TesttaskSitemapPhpPkg\Facades\Sitemap;
use Slartibax\TesttaskSitemapPhpPkg\Tags\Url;

require_once __DIR__ . '/vendor/autoload.php';

// Example data
$testData = [
    ["loc" => "https://site.ru/about", "lastmod" => "2020-12-07", "priority" => "0.1", "changefreq" => "weekly"],
    ["loc" => "https://site.ru/about", "lastmod" => "2020-12-07", "priority" => "0.1", "changefreq" => "weekly"],
    ["loc" => "https://site.ru/about", "lastmod" => "2020-12-07", "priority" => "0.1", "changefreq" => "weekly"],
];

// Use facade to configure and start object
$sitemap = Sitemap::make()
    ->filePath(__DIR__ . '/testdir/sitemap.json')
    ->xml()
//    ->json()
//    ->csv()
    ->start();

// Pass tag object for each item
foreach ($testData as $data) {
    $sitemap->addTag(
        new Url($data)
    );
}

// Call complete to finalize generation
$sitemap->complete();
```