<?php

namespace App\Admin\Resources;

/**
 * Class TestResource
 *
 * @package App\Admin\Resources
 */
class Test1Resource extends JsonResource
{
    public const FOR_INFO = 'info';

    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'type'        => $this->type,
            'create_time' => $this->create_time,
        ];
    }
}
