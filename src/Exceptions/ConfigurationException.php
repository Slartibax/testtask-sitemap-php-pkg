<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Exceptions;

use Exception;

class ConfigurationException extends Exception
{
    protected $message = 'Wrong configuration';
}