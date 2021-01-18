<?php

namespace App\Admin\Controllers;

use App\Admin\Services\ExcelService;
use Illuminate\Http\Request;

/**
 * Class ExcelController 导入表格
 *
 * @author  hogen
 * @package App\Admin\Controllers
 */
class ExcelController extends Controller
{
    /**
     * 导入excel表格--demo
     *
     * @param \Illuminate\Http\Request         $request
     * @param \App\Admin\Services\ExcelService $service
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function importDemo(Request $request, ExcelService $service)
    {

        $file = $request->file('file');
        if (!$file) {
            $this->error('参数错误');
        }

        $res = $service->demoImportExcel($file);
        if ($res === false) {
            $this->error($service->getError());
        }
        return $this->ok($res);
    }

}
