<?php

namespace Hogen\Api\Exceptions\Client;

use Hogen\Api\Exceptions\BaseException;

/**
 * Class BadRequestException
 *
 * @package Hogen\Api\Exceptions\Client
 */
class BadRequestException extends BaseException
{
    /**
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = '请求出错', \Exception $previous = null, $code = 0)
    {
        parent::__construct(400, $message, $previous, [], $code);
    }
}
