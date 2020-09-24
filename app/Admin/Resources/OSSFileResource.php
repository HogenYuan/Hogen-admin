<?php

namespace App\Admin\Resources;


/**
 * Class OSSFileResource
 *
 * @package App\Admin\Resources
 */
class OSSFileResource extends BaseResource
{
    public static function properties(): array
    {
        return [
            'url'       => static::propString('请求连接'),
            'file_type' => static::propString('文件类型'),
            'file_size' => static::propInt('文件大小'),
            'file_code' => static::propString('文件code'),
            'file_name' => static::propString('文件名称'),
        ];
    }
}
