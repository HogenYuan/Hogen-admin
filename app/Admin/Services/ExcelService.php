<?php


namespace App\Admin\Services;

use App\Admin\Utils\Excel\Import\DemoImport;
use Illuminate\Support\Facades\Log;

define('DS', DIRECTORY_SEPARATOR);

/**
 * Class ExcelService 导入表格-服务
 *
 * @author  hogen
 * @package App\Admin\Services\Admin
 */
class ExcelService extends BaseService
{
    /**
     * 导入表格
     *
     * @param $file
     *
     * @return array|false
     */
    public function demoImportExcel($file)
    {
        set_time_limit(0);
        try {
            //TODO 使用laravel验证文件
//            $fileUploadConfig = config('file_upload');
//            $localSheet = FileLogic::uploadFile($file, $fileUploadConfig);
//            if (!isset($localSheet['ext']) || $localSheet['ext'] != 'xlsx') {
//                $this->error = '暂不支持此种格式导入';
//                return false;
//            }

            $localSheet     = [
                'path' => '',
            ];
            $localSheetPath = app_path() . DS . 'public' . DS . $localSheet['path'];
        } catch (\Exception $exception) {
//            Log::info(implode("\n", [
//                '描述：保存导入的 Excel 异常',
//                '文件：' . $exception->getFile(),
//                '行数：' . $exception->getLine(),
//                '异常信息：' . $exception->getMessage(),
//                '参数：' . json_encode(compact('file'), JSON_UNESCAPED_UNICODE),
//            ]), 'k3cloud');
            Log::info('demo', [
                '描述：保存导入的 Excel 异常',
                '文件：' . $exception->getFile(),
                '行数：' . $exception->getLine(),
                '异常信息：' . $exception->getMessage(),
                '参数：' . json_encode(compact('file')),
            ]);
            $this->error = '保存导入的 Excel 异常:' . $exception->getMessage();
            return false;
        }
        $import = new DemoImport($localSheetPath);

        $res = $import->parseExcel();
        if ($res === false) {
            $this->error = $import->getError();
            return false;
        }
        return ['data' => $res];
    }
}