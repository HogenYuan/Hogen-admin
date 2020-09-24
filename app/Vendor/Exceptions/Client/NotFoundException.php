<?php

namespace Vendor\Exceptions\Client;

use Vendor\Exceptions\BaseException;

/**
 * Class NotFoundException
 *
 * @package App\Exceptions\Client
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
