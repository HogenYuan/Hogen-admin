<?php

namespace Vendor\Exceptions\Client;

use Vendor\Exceptions\BaseException;

/**
 * Class AuthenticationException
 *
 * @package App\Exceptions\Client
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
