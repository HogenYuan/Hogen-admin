<?php

namespace App\Admin\Utils\Excel\Import;

/**
 * @author  hogen
 * @package App\Admin\Utils\Excel\Import
 */
interface IExcelImport
{

    /**
     * 检测模板是否符合规则
     */
    public function checkTemplate();

    /**
     *获取相关的模板数据
     */
    public function getTemplateData();


}