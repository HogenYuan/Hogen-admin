<?php

namespace App\Admin\Services\Admin;


use App\Admin\Services\BaseService;
use Urland\Exceptions\Client;

class AdminService extends BaseService
{
    /**
     * 创建管理员
     *
     * @return mixed
     */
    public static function create()
    {
        $login = true;
        if ($login) {
            throw new Client\BadRequestException('该管理员登录账号已存在');
        }
    }
}