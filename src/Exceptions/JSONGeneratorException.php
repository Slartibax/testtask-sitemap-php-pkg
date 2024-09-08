<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Exceptions;

use Exception;

class JSONGeneratorException extends Exception
{
    protected $message = 'Error in JSON generator';
}