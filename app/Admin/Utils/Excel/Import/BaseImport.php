<?php

namespace App\Admin\Utils\Excel\Import;

/**
 * @author   hogen
 * @package  App\Admin\Utils\Excel\Import;
 */
class BaseImport implements IExcelImport
{
    protected $_error = '';
    protected $_filePath = '';
    protected $_excelObj = null;
    protected $_tempTitles = [];
    protected $_itemData = [];

    public function parseExcel()
    {
        //初始对象获取
        if (!$this->setExcelObj()) {
            return false;
        }
        //校验模板规则,是否符合匹配规则
        if (!$this->checkTemplate()) {
            return false;
        }
        //获取模板中的相关数据
        if (!$this->getTemplateData()) {
            return false;
        }
        //
        return $this->dealData();
    }

    /**
     * 创建excel
     */
    public function setExcelObj()
    {
        if (!$this->_filePath) {
            $this->setError('请传入正确的路径');
            return false;
        }

        $excelReadObj    = \PHPExcel_IOFactory::createReader('Excel2007');
        $this->_excelObj = $excelReadObj->load($this->_filePath)->getSheet(0);
        return true;
    }

    /**
     * 检测模板是否符合规则
     */
    public function checkTemplate()
    {

        $sheetTitles = array_values($this->_tempTitles);

        $importSheetTitles = [];
        for ($i = 0; $i < count($sheetTitles); $i++) {
            $importSheetTitles[] = trim($this->_excelObj->getCellByColumnAndRow($i, 1)->getValue());
        }

        if ($sheetTitles != $importSheetTitles) {
//            $this->setError('模板中的表头不可更改，不可删除');
            $this->setError('模板不正确');
            return false;
        }

        return true;


    }

    /**
     * 获取相关的模板数据
     */
    public function getTemplateData()
    {
        $highestRow = $this->_excelObj->getHighestRow();
        if ($highestRow - 1 > 5000) {
            $this->setError('不能导入超过5000条');
            return false;
        }
        // 解析数据
        $sheetItems       = [];
        $sheetTitleFields = array_keys($this->_tempTitles);
        for ($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++) {
            $item = [];
            for ($columnIndex = 0; $columnIndex < count($sheetTitleFields); $columnIndex++) {
                $field        = $sheetTitleFields[$columnIndex];
                $item[$field] = trim($this->_excelObj->getCellByColumnAndRow($columnIndex, $rowIndex)->getValue());
            }
            $sheetItems[$rowIndex] = $item;
        }

        // 处理
        if (empty($sheetItems)) {
            $this->setError('解析后的数据异常');
            return false;
        }
        $this->_itemData = $sheetItems;
        return true;


    }

    /**
     * 处理信息
     */
    public function dealData()
    {
    }


    /**
     *设置错误信息
     *
     * @param $msg
     */
    public function setError($msg)
    {
        $this->_error = $msg;
    }

    /**
     * 获取错误信息
     */
    public function getError()
    {
        return $this->_error;
    }

    //处理数据中存在的特殊字符
    protected function _filterData(&$item = [])
    {
        if ($item) {
            foreach ($item as $k => $v) {
                $item[$k] = $this->_replaceSpecialStr($v);
            }
        }
    }

    protected function _replaceSpecialStr($str)
    {
        if (!$str) {
            return $str;
        }
        $str = mb_ereg_replace([chr(194), chr(160)], '', $str);
        return $str;
    }


}