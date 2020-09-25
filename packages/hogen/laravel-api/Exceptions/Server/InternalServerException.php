<?php

namespace Hogen\Api\Exceptions\Server;

use Hogen\Api\Exceptions\BaseException;


/**
 * Class InternalServerException
 * 未知原因导致服务不可用，需要紧急处理
 *
 * @package Hogen\Api\Exceptions\Server
 */
class InternalServerException extends BaseException
{
    /**
     * ServiceUnavailableException constructor.
     *
     * @param string          $message
     * @param \Exception|null $previous
     * @param int             $code
     */
    public function __construct($message = '系统错误', \Exception $previous = null, $code = 0)
    {
        parent::__construct(500, $message, $previous, [], $code);
    }
}