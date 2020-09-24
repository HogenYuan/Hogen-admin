<?php

namespace App\Admin\Services;

abstract class BaseService
{
    /**
     * 更新冗余数据
     *
     * @param array $updates
     * @param array $defaultColumns
     * @param mixed $whereValue
     * @param mixed $updateValue
     *
     * @return int
     */
    protected static function updateRedundantData(
        array $updates,
        array $defaultColumns,
        $whereValue,
        $updateValue
    ): int {
        $updateCount = 0;
        foreach ($updates as $className => $columns) {
            // 采用默认值
            if (is_numeric($className)) {
                $className = $columns;
                $columns   = $defaultColumns;
            }

            $tableName = (new $className)->getTable();
            foreach ($columns as $whereColumn => $updateColumn) {
                $updateCount += \DB::table($tableName)->where($whereColumn,
                    $whereValue)->update([$updateColumn => $updateValue]);
            }
        }

        return $updateCount;
    }
}
