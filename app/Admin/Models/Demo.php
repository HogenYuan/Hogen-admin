<?php

namespace App\Admin\Models;

use App\Admin\Models\Traits\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Demo
 *
 * @package App\Admin\Models
 */
class Demo extends Model
{
    use Filter;

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '测试';
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'demo';
    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * 返回该字段自动设置为 Carbon 对象
     *
     * @var array
     */
    protected $dates = [
        'created_time',
    ];

    /**
     * 查询器
     */
    public function filters(): array
    {
        return [
            'main_card_uuid',
            'nickname' => function ($val) {
                return $this->filterBuilder->whereHas('gasStationMainCard', function (Builder $query) use ($val) {
                    $query->where('nickname', 'like', "%{$val}%");
                });
            },
        ];
    }

}
