<?php

namespace Hogen\Api\Exceptions\Client;

use Hogen\Api\Exceptions\BaseException;

/**
 * Class NotFoundException
 *
 * @package Hogen\Api\Exceptions\Client
 */
class NotFoundException extends BaseException
{
    /**
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = '找不到资源', \Exception $previous = null, $code = 0)
    {
        parent::__construct(404, $message, $previous, [], $code);
    }
}
