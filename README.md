# Laravel-Service

![php-badge](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg)
[![packagist-badge](https://img.shields.io/packagist/v/keepondream/laravel-service.svg)](https://packagist.org/packages/keepondream/laravel-service)
[![Total Downloads](https://poser.pugx.org/keepondream/laravel-service/downloads)](https://packagist.org/packages/keepondream/laravel-service)


## 兼容版本

| PHP     | Laravel | Lumen |
|:-------:|:-------:|:-----:|
| >=7.0 | >=5.7    | >=5.7  |

## 说明

* 在 **Laravel/Lumen** 生命周期中单例所有 **Service(业务服务层)**
* 利用php artisan make:service 快速构建服务层
* 具有灵活的调用方式

```
    适用于中小项目构建分层:
    Request     - 数据验证层
    Controller  - 控制器层
    Service     - 服务层
    Model       - 模型层
    结构清晰简单,避免Controller层代码冗余,Service层适度抽象复用代码
    由于 Laravel 的 Eloquent ORM 实现已经很强大了,所以这里去除了
    Repository层的抽象封装,上手容易.
```

## 安装

- 使用composer 安装
```
composer require keepondream/laravel-service

```

- 添加服务提供商,将下面这行添加至 config/app.php 文件 providers 数组中：
```
'providers' => [
  ...
  Keepondream\LaravelService\Providers\LaravelServiceProvider::class
 ]
```

## 使用示例

- 利用artisan命令构建Service文件

``` 
# 项目目录执行命令:
php artisan make:service {模型名称或者自定义名称(user)}
```

- Service目录

``` 
app
    - Services
        - UserService.php
        - AdminService.php
        - ...
```

- 生成的Service文件

``` 
<?php
/**
 * Description: UserService service
 * Author: WangSx
 * DateTime: 2019-11-28 13:22
 */
namespace App\Services;
use Keepondream\serviceSingleInstance\Service as BaseService;

/**
 * Author: WangSx
 * DateTime: 2019-11-28 13:22
 * Class UserService
 * @package App\Services
 * @method static string echo() echo 
 */
class UserService extends BaseService
{
    /**
     * Description: echo 
     * Author: WangSx
     * DateTime: 2019-11-28 21:23
     * @return string
     */
    public function _echo()
    {
        return "echo";
    }
    
}
```

- 使用方法

``` 
  # 方法一: 直接静态调用,应为做了'_'方法名映射
  UserService::echo();  // 返回 字符串 'echo'
        
  # 方法二: 通过静态调用获取实例,进行链式操作
  UserService::getInstance()->_echo(); // 返回 字符串 'echo'

```