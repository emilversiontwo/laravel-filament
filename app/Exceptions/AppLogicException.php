<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class AppLogicException extends Exception
{
    protected $code = 500;

    public static function forbidden(): self
    {
        return new self('Insufficient permissions', ResponseCode::HTTP_FORBIDDEN);
    }
}
