# laravel-service

#### 配置
- 添加服务提供商
- 将下面这行添加至 config/app.php 文件 providers 数组中：
```
'providers' => [
  ...
  Keepondream\LaravelService\Providers\LaravelServiceProvider::class
 ]
```