<?php

namespace Hogen\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;

class JsonResource extends BaseJsonResource
{
    /**
     * 返回的数据用 $wrap 包裹
     *
     * @var null
     */
    public static $wrap = null;

    /**
     * @var string 自定义的场景，根据不同场景，来组合不同的返回字段
     */
    protected static $for;

    /**
     * 通用日期格式
     *
     * @var string
     */
    protected static $dateTimeFormat = DATE_RFC3339;

    /**
     * 根据for返回Collection的类型
     *
     * @param string $for
     * @param mixed  ...$parameters
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Vendor\Http\Resources\ResourceCollection
     */
    public static function forCollection(string $for, ...$parameters)
    {
        static::$for = $for;

        return static::collection(...$parameters);
    }

    /**
     * 返回新的匿名Collection
     *
     * @param mixed $resource
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Vendor\Http\Resources\ResourceCollection
     */
    public static function collection($resource)
    {
        return tap(new AnonymousResourceCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

    /**
     * 日期格式化
     *
     * @param \DateTimeInterface|null $datetime
     * @param mixed                   $default
     *
     * @return string|mixed
     */
    protected static function formatDateTime(?\DateTimeInterface $datetime, $default = null): string
    {
        return $datetime ? $datetime->format(static::$dateTimeFormat) : $default;
    }

    /**
     * 获取对应for
     *
     * @param string $for
     *
     * @return $this
     */
    public function for(string $for)
    {
        static::$for = $for;

        return $this;
    }

    /**
     * 合并当前for到返回数据
     *
     * @param string $for
     * @param mixed  $parameters
     *
     * @return $this
     */
    public function mergeFor(string $for, ...$parameters)
    {
        return $this->mergeWhen(static::$for === $for, ...$parameters);
    }


}
