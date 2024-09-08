<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Generators;

use Exception;
use InvalidArgumentException;
use Slartibax\TesttaskSitemapPhpPkg\Exceptions\XMLGeneratorException;
use Slartibax\TesttaskSitemapPhpPkg\SitemapGenerator;
use Slartibax\TesttaskSitemapPhpPkg\SitemapTag;

class XMLGenerator implements SitemapGenerator
{
    private $fileHandle;

    const DEFAULT_HEADER = '<?xml version="1.0" encoding="UTF-8" ?>' . PHP_EOL . '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
    const DEFAULT_FOOTER = '</urlset>' . PHP_EOL;

    /**
     * @throws Exception
     */
    public function __construct($fileHandle)
    {
        if (!is_resource($fileHandle)) {
            throw new InvalidArgumentException('File handle must be a resource');
        }
        $this->fileHandle = $fileHandle;
    }

    /**
     * @throws Exception
     */
    public function initialize(): void
    {
        fwrite($this->fileHandle, self::DEFAULT_HEADER)
            ?: throw new XMLGeneratorException('Can\'t write initialize data to file. Can\'t write header to file');
    }

    /**
     * @throws Exception
     */
    public function processTag(SitemapTag $tag): void
    {
        $tagKey = $tag->getKey();
        $text = "\t<$tagKey>" . PHP_EOL;
        foreach ($tag->getFields() as $key => $value) {
            $text .= sprintf("\t\t<%s>%s</%s>%s", $key, $value, $key, PHP_EOL);
        }
        $text .= "\t</$tagKey>" . PHP_EOL;

        fwrite($this->fileHandle, $text)
            ?: throw new XMLGeneratorException('Can\'t write generated element text to file');
    }

    /**
     * @throws Exception
     */
    public function finalize(): void
    {
        fwrite($this->fileHandle, self::DEFAULT_FOOTER)
            ?: throw new XMLGeneratorException('Can\'t finalize data in file. Can\'t write footer to file');

        fclose($this->fileHandle)
            ?: throw new XMLGeneratorException('Can\'t close file stream');
    }
}