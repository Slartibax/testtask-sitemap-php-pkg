<?php

namespace Slartibax\TesttaskSitemapPhpPkg\Exceptions;

use Exception;

class FilePreparationException extends Exception
{
    protected $message = 'Can\'t create directory or file';
}