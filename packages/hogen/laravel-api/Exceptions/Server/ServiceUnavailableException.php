<?php

namespace Hogen\Api\Exceptions\Server;

use Hogen\Api\Exceptions\BaseException;

/**
 * Class ServiceUnavailableException
 * 已知原因导致服务暂不可用，通常用于更新维护
 *
 * @package Hogen\Api\Exceptions\Server
 */
class ServiceUnavailableException extends BaseException
{
    /**
     * ServiceUnavailableException constructor.
     *
     * @param string          $message
     * @param \Exception|null $previous
     * @param int             $code
     */
    public function __construct($message = '服务器暂不可用', \Exception $previous = null, $code = 0)
    {
        parent::__construct(503, $message, $previous, [], $code);
    }
}