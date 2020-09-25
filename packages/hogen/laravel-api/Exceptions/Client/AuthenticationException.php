<?php

namespace Hogen\Api\Exceptions\Client;

use Hogen\Api\Exceptions\BaseException;

/**
 * Class AuthenticationException
 *
 * @package Hogen\Api\Exceptions\Client
 */
class AuthenticationException extends BaseException
{
    /**
     * AuthorisationException constructor.
     *
     * @param string          $message
     * @param \Exception|null $previous
     * @param int             $code
     */
    public function __construct($message = '客户端尚未登录', \Exception $previous = null, $code = 0)
    {
        parent::__construct(401, $message, $previous, [], $code);
    }
}
