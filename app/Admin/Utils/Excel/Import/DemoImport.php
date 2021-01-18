<?php

namespace App\Admin\Utils\Excel\Import;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

/**
 *
 * Class DemoImport
 *
 * @package App\Admin\Utils\Excel\Import
 */
class DemoImport extends BaseImport
{

    public function __construct($filePath)
    {
        $this->_filePath   = $filePath;
        $this->_tempTitles = [
            'FStockId' => '第三方仓库编码',
            'FName'    => '第三方仓库名称',
            'name'     => '仓库',
        ];
    }

    /**
     * 处理信息
     */
    public function dealData()
    {
        $zid = 1;
        //返回结果数组
        $result   = [
            'fail_num'   => 0,
            'error_list' => [],
            'succ_num'   => 0,
        ];
        $itemData = $this->_itemData;
        if (empty($itemData)) {
            $this->setError('导入数据不能为空');
            return false;
        }
        $successList = [];//新数据列表
        $widArr      = [];//仓库id列表
        $fStockIdArr = [];//仓库编码列表

        //TODO 获取数据
//        $data  = K3Stock::where()->select();

        if (empty($stockData)) {
            $this->setError('请先同步仓库');
            return false;
        }
        foreach ($stockData as $v) {
            $fStockIdArr[] = $v['FStockId'];
            if ($v['wid'] != 0) {
                $widArr[] = $v['wid'];
            }
        }
        foreach ($itemData as $key => $item) {
            //所有项都为空，忽略这行，
            if (!array_filter($item)) {
                continue;
            }
            $this->_filterData($item);

            //先校验该行格式最基本的数据格式
            if (!$this->_checkItemData($item)) {
                $result['fail_num']     += 1;
                $result['error_list'][] = array_merge([
                    'row' => $key,
                    'msg' => $this->getError(),
                ], $item);
                continue;
            }
            //校验FStockId
            if (!in_array($item['FStockId'], $fStockIdArr)) {
                $result['fail_num']     += 1;
                $result['error_list'][] = array_merge([
                    'row' => $key,
                    'msg' => "该第三方仓库编码不存在",
                ], $item);
                continue;
            }
            //仓库是否为该ZID，是否合法
            $wid = WareHouse::where([
                'zid'       => $zid,
                'name'      => $item['name'],
                'is_delete' => 0,
            ])->value('wid');
            if (!$wid) {
                $result['fail_num']     += 1;
                $result['error_list'][] = array_merge([
                    'row' => $key,
                    'msg' => "仓库不存在",
                ], $item);
                continue;
            }
            //校验仓库
            if (in_array($wid, $widArr)) {
                $result['fail_num']     += 1;
                $result['error_list'][] = array_merge([
                    'row' => $key,
                    'msg' => "该仓库已配对其他仓库",
                ], $item);
                continue;
            }

            //绑定
            $insertData = [
                'wid'          => $wid,
                'is_bind'      => 1,
                'gmt_modified' => date('Y-m-d H:i:s'),
            ];

            try {
                DB::name('k3_stock')
                    ->where([
                        'zid'      => ZID,
                        'k3id'     => K3ID,
                        'FStockId' => $item['FStockId'],
                    ])
                    ->update($insertData);
            } catch (\Exception $e) {
                $result['fail_num']     += 1;
                $result['error_list'][] = array_merge([
                    'row' => $key,
                    'msg' => $e->getMessage(),
                ], $item);
                continue;
            }

            //绑定后添加到已绑
            $nameArr[] = $item['name'];
            $result['succ_num']++;
            $successList['item_list'][] = $insertData;
        }
        if (empty($successList['item_list']) && $result['succ_num'] == 0 && $result['fail_num'] == 0) {
            $this->setError('导入数据不能为空');
            return false;
        }

        //有失败数据，先存redis
        if ($result['fail_num'] > 0) {
            $redis = new Redis();
//            $redis = Redis::getInstance();
            $key = 'demo_' . md5(uniqid());
            $redis->Set($key . "_list", json_encode($result['error_list'], JSON_UNESCAPED_UNICODE), 600);
            $redis->Set($key . "_title", json_encode(array_merge([
                'row' => '行号',
                'msg' => '失败原因',
            ], $this->_tempTitles), JSON_UNESCAPED_UNICODE), 600);
            $result['error_file_id'] = $key;
        }
        return $result;
    }

    /**
     * @param $data
     *
     * @return bool
     */
    private function _checkItemData($data)
    {
        if (!$data) {
            $this->setError('校验参数不能为空');
            return false;
        }
        $rules    = [
            'FStockId|第三方仓库编码' => 'require',
            'FName|第三方仓库名称'    => 'require',
            'name|仓库'          => 'require',
        ];
        $msg      = [
            'FStockId.require' => '第三方仓库编码不能为空',
            'FName.require'    => '第三方仓库名称不能为空',
            'name.require'     => '仓库不能为空',
        ];
        $validate = new Validate($rules, $msg);
        $result   = $validate->check($data);
        if (!$result) {
            $this->setError($validate->getError());
            return false;
        }
        return true;
    }

}