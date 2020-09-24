## 后端代码生成器(Generator)
---
### Introduction
1. 根据目前框架生成默认代码
2. `model + filter + request + resource + service + controller`
3. 模板样式改造*.stub
---
### Installation
    composer require xxxx
---
### Demo
```bash
## name : 必填，短横式命名的资源名称}
## --module= : 必填，指定三级模块(大小写规范) 如：GasStation/MainCard/Balance
## --prefix= : 指定二级前缀(大小写规范) 默认：AdminApi
## --baseDir= : 指定一级目录(大小写规范) 默认：Http
## --force : 覆盖已存在文件
## --test : 生成控制器测试类
php artisan admin:make-resource testExample --force --baseDir=Http --prefix=AdminApi --module=GasStation\Maincard\Xxx
```
---
### Develop自定义
**MakeResource.php**
```php
protected $types = [
    'filter', 'model', 'request', 'resource', 'service', 'controller', 'test', 'migration'
];
```
 * 选择需要生成的组件
 * 有先后顺序之分
<br/><br/>
```php
protected $pathFormat = [
    'model'      => ['inBaseDir' => false, 'prefix' => ''],
    'service'    => ['inBaseDir' => false, 'prefix' => ''],
    'test'       => ['inBaseDir' => false, 'prefix' => true],
    'filter'     => ['inBaseDir' => true, 'prefix' => true],
    'request'    => ['inBaseDir' => true, 'prefix' => true],
    'resource'   => ['inBaseDir' => true, 'prefix' => true],
    'controller' => ['inBaseDir' => true, 'prefix' => true],
    'migration'  => ['inBaseDir' => false, 'prefix' => ''],
];
```
 * 默认
 * 在此修改各模块的路径规则设置
 * inBaseDir决定是否在Http内
 * prefix决定是否有二级前缀
 <br/><br/>
```php
protected $createFilterHelper = true;
```
* 在此修改是否需要新建trait filterHelpers
* @var boolean
<br/><br/><br/>
**stubs\\*.stub**
* 配置各句柄默认语句


