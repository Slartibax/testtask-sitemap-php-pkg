<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Generators;

use Exception;
use InvalidArgumentException;
use Slartibax\TesttaskSitemapPhpPkg\Exceptions\JSONGeneratorException;
use Slartibax\TesttaskSitemapPhpPkg\SitemapGenerator;
use Slartibax\TesttaskSitemapPhpPkg\SitemapTag;

class JSONGenerator implements SitemapGenerator
{
    private $fileHandle;

    const DEFAULT_HEADER = '[';
    const DEFAULT_FOOTER = ']' . PHP_EOL;

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
            ?: throw new JSONGeneratorException('Can\'t write initialize data to file. Can\'t write header to file');
    }

    /**
     * @throws Exception
     */
    public function processTag(SitemapTag $tag): void
    {
        $text = json_encode($tag->getFields(), JSON_PRETTY_PRINT) . ',' . PHP_EOL;

        fwrite($this->fileHandle, $text)
            ?: throw new JSONGeneratorException('Can\'t write generated element text to file');
    }

    /**
     * @throws Exception
     */
    public function finalize(): void
    {
        $stat = fstat($this->fileHandle)
            ?: throw new JSONGeneratorException('Can\'t finalize data in file. Can\'t get file stat');

        ftruncate($this->fileHandle, $stat['size'] - 1)
            ?: throw new JSONGeneratorException('Can\'t finalize data in file. Can\'t truncate file');

        $fseekCode = fseek($this->fileHandle, -1, SEEK_END);
        if ($fseekCode !== 0) {
            throw new JSONGeneratorException('Can\'t finalize data in file. Can\'t seek file');
        }

        fwrite($this->fileHandle, self::DEFAULT_FOOTER)
            ?: throw new JSONGeneratorException('Can\'t finalize data in file. Can\'t write footer to file');

        fclose($this->fileHandle)
            ?: throw new JSONGeneratorException('Can\'t close file stream');
    }
}