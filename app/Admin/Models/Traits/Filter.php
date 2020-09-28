<?php

namespace App\Admin\Models\Traits;

use Closure;
use Illuminate\Database\Eloquent\Builder;


/**
 * 通用模型中的方法
 *
 * Trait Filter
 *
 * @package App\Admin\Models\Traits
 */
trait Filter
{
    /**
     * @var array
     */
    protected $filterData;

    /**
     * @var Builder
     */
    protected $filterBuilder;

    /**
     * @var array
     */
    protected $filters;

    /**
     * 应用过滤器
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array                                 $validated
     *
     * @return mixed
     */
    public function scopeFilter(Builder $builder, array $validated)
    {
        $this->filterData = $validated;
        return $this->apply($builder);
    }

    /**
     * 应用过滤
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return mixed
     */
    public function apply(Builder $builder)
    {
        $this->filters       = $this->filters();
        $this->filterBuilder = $builder;

        $this->formatSimpleFilters();
        foreach ($this->filterData as $filterName => $value) {
            if (is_null($value)) {
                continue;
            }

            if (isset($this->filters[$filterName])) {
                $op = $this->filters[$filterName];
                if (is_callable($op)) {
                    //匿名函数，复杂查询
                    $op($value);
                } else {
                    $this->applySimpleFilter($filterName, $op, $value);
                }
            }
        }
        return $this->filterBuilder;
    }

    /**
     * 把 simpleFilters 中没有指定过滤类型的, 自动改为 '='
     */
    protected function formatSimpleFilters()
    {
        $t = [];
        foreach ($this->filters as $field => $op) {
            if ($op instanceof Closure) {
                $t[$field] = $op;
            } elseif (is_int($field)) {
                $t[$op] = 'equal';
            };
        }
        $this->filters = $t;
    }

    /**
     * 过滤简单过滤器
     *
     * @param string       $filterName 过滤字段
     * @param string|array $op         操作
     * @param mixed        $value      请求中对应的值
     */
    protected function applySimpleFilter(string $filterName, $op, $value)
    {
        if (is_array($op)) {
            $args = array_slice($op, 1);
            $op   = $op[0];
        }

        switch ($op) {
            case 'equal':
                $this->filterBuilder->where($filterName, $value);
                break;
            case 'like':
                $this->filterBuilder->where($filterName, 'like', str_replace('?', $value, $args[0]));
                break;
            default:
        }
    }
}
