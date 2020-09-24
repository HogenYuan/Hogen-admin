<?php

namespace Vendor\Exceptions\Client;

use Vendor\Exceptions\BaseException;

/**
 * Class ForbiddenException
 *
 * @package App\Exceptions\Client
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
