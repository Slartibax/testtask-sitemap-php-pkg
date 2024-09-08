<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Generators;

use Exception;
use InvalidArgumentException;
use Slartibax\TesttaskSitemapPhpPkg\SitemapGenerator;
use Slartibax\TesttaskSitemapPhpPkg\SitemapTag;
use Slartibax\TesttaskSitemapPhpPkg\Tags\Url;

class CSVGenerator implements SitemapGenerator
{
    private $fileHandle;

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
        fwrite($this->fileHandle, implode(";", array_keys((new Url([]))->getFields())) . PHP_EOL)
            ?: throw new Exception('Can\'t write initialize data to file');
    }

    /**
     * @throws Exception
     */
    public function processTag(SitemapTag $tag): void
    {
        $text = "";
        foreach ($tag->getFields() as $value) {
            $text .= $value . ";";
        }

        $text = trim($text, ';') . PHP_EOL;

        fwrite($this->fileHandle, $text)
            ?: throw new Exception('Can\'t write element to file');
    }

    /**
     * @throws Exception
     */
    public function finalize(): void
    {
        fclose($this->fileHandle)
            ?: throw new Exception('Can\'t close file stream');
    }
}