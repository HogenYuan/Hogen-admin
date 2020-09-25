<?php

namespace Hogen\Api\Exceptions\Client;

use Hogen\Api\Exceptions\BaseException;

/**
 * Class ForbiddenException
 *
 * @package Hogen\Api\Exceptions\Client
 */
class ForbiddenException extends BaseException
{
    /**
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = '权限不足', \Exception $previous = null, $code = 0)
    {
        parent::__construct(403, $message, $previous, [], $code);
    }
}
