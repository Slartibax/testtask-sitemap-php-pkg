<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Exceptions;

use Exception;

class CSVGeneratorException extends Exception
{
    protected $message = 'Error in CSV generator';
}