# laravel项目常量库

用于方便管理和调用数据库常量。

### 安装方法
```shell
    composer require urland/laravel-constant
    php artisan vendor:publish --tag=urland-constant
```
### 配置
resources/constant/demo.php
```php
    return [
        'pay' => [
            'type' => [
                'alipay' => '支付宝',
                'wechat' => '微信支付',
            ],
        ],
    ];
```
config/constant.php
```php
    /*
    |--------------------------------------------------------------------------
    | 描述文件生成路径
    |--------------------------------------------------------------------------
    | PhpStorm会自动加载识别根目录下.phpstorm.meta.php文件或.phpstorm.meta.php目录下
    | 的所有文件，此处需与ide-helper同时配置。
    */
    'meta_filename' => 'constant.php',
```
生成缓存和IDE
```shell 
    php artisan constant:cache
    php artisan constant:meta
```
### 使用
1. 获取常量值
```php
    $payTypeKey = 'wechat';
    $payTypeId = cons('pay.type.' . $payTypeKey);
    // $payTypeId == 2
```

2. 根据常量值获取key
```php
    $payTypeId = 2;
    $payTypeKey = cons()->key('pay.type', $payTypeId);
    // $payTypeKey == 'wechat'

    // 获取 id => key 方式的数组
    $payTypeKeys = cons()->key('pay.type');
    /*
        $payTypeKeys == [
            1 => 'alipay',
            2 => 'wechat',
        ];
    */
```

3. 获取常量对应语言
```php
    $payTypeKey = 'wechat';
    $payTypeName = cons()->lang('pay.type.' . $payTypeKey);
    // $payTypeName == '微信支付'
```

4. 根据常量值获取对应语言
```php
    $payTypeId = 2;
    $payTypeName = cons()->valueLang('pay.type', $payTypeId);
    // $payTypeName == '微信支付'

    // 获取 id => key 方式的数组
    $payTypeNames = cons()->valueLang('pay.type');
    /*
        $payTypeKeys == [
            1 => '支付宝',
            2 => '微信支付',
        ];
    */
```

5. 命令
```shell
## 生成缓存
php artisan constant:cache 
## 更新IDE
php artisan constant:meta  
## 清除缓存
php artisan constant:clear
```