<?php

namespace App\Admin\Resources;

/**
 * Class TestResource
 *
 * @package App\Admin\Resources
 */
class TestResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public static function properties(): array
    {
        return [
            'type' => static::propString('管理公司名称'),
            'id'   => static::propInt('公司UUID'),
            'e'    => static::propString('公司UUID'),
        ];
    }
}
