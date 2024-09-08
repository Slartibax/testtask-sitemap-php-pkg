<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Exceptions;

use Exception;

class XMLGeneratorException extends Exception
{
    protected $message = 'Error in XML generator';
}