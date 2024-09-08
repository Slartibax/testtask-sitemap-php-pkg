<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Facades;

use Exception;
use Slartibax\TesttaskSitemapPhpPkg\Generators\CSVGenerator;
use Slartibax\TesttaskSitemapPhpPkg\Generators\JSONGenerator;
use Slartibax\TesttaskSitemapPhpPkg\Generators\XMLGenerator;
use Slartibax\TesttaskSitemapPhpPkg\SitemapGenerator;
use Slartibax\TesttaskSitemapPhpPkg\SitemapTag;

class Sitemap
{
    private ?SitemapGenerator $generator = null;
    private ?string $filePath = null;
    private ?string $chosenGeneratorClassname = null;

    public static function make(): self
    {
        return new self();
    }

    public function filePath(string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function useGenerator(SitemapGenerator $generator): self
    {
        if (is_null($this->filePath)) {
            throw new Exception('File path must be set before generator is used');
        }

        $this->generator = $generator;
        return $this;
    }

    public function xml(): self
    {
        $this->chosenGeneratorClassname = XMLGenerator::class;
        return $this;
    }


    public function json(): self
    {
        $this->chosenGeneratorClassname = JSONGenerator::class;
        return $this;
    }


    public function csv(): self
    {
        $this->chosenGeneratorClassname = CSVGenerator::class;
        return $this;
    }


    public function start(): self
    {
        if (is_null($this->filePath)) {
            throw new Exception('File path must be set before start');
        }

        $this->prepareLocation();

        if (is_null($this->generator)) {
            if (is_null($this->chosenGeneratorClassname)) {
                throw new Exception('Generator must be set or chosen before start');
            } else {
                $this->generator = new $this->chosenGeneratorClassname(fopen($this->filePath, 'w+'));
            }
        }

        $this->generator->initialize();
        return $this;
    }

    public function addTag(SitemapTag $tag): self
    {
        $this->generator->processTag($tag);
        return $this;
    }

    public function complete(): self
    {
        $this->generator->finalize();
        return $this;
    }

    private function prepareLocation(): void
    {
        $directory = dirname($this->filePath);

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true)
                ?: throw new Exception('Can\'t create directory structure');
        }

        $status = file_put_contents($this->filePath, '');

        if ($status === false) {
            throw new Exception('Can\'t create file');
        }
    }


}