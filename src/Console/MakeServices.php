<?php
/**
 * Description:
 * Author: WangSx
 * DateTime: 2019-11-28 07:42
 */

namespace Keepondream\LaravelService\Console;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;

/**
 * Author: WangSx
 * DateTime: 2019-11-28 13:17
 * Class MakeServices
 * @package Keepondream\LaravelService\Console
 */
class MakeServices extends GeneratorCommand
{
    /**
     * 控制台命令 signature 的名称。
     *
     * @var string
     */
    protected $signature = 'make:service {modelName}';

    /**
     * 控制台命令说明。
     *
     * @var string
     */
    protected $description = 'create Service modelName';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var string
     */
    protected $time;

    const BASE_PATH = 'App' . DIRECTORY_SEPARATOR;

    const SERVICE_PATH = self::BASE_PATH . 'Services';


    /**
     * Author: WangSx
     * DateTime: 2019-11-28 13:07
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $fullModelName = strtolower($this->argument('modelName'));

        if (empty($fullModelName)) {
            $this->error("you can : php artisan make:service User/FirstUser ; \n will make FirstUserService.php Success");
            return true;
        }

        $name_arr = explode('/', $fullModelName);
        $name_count = count($name_arr);

        $path = self::SERVICE_PATH;
        if ($name_count > 1) {
            for ($i = 0; $i < $name_count - 1; $i++) {
                $path .= DIRECTORY_SEPARATOR . ucfirst($name_arr[$i]);
            }
        }
        $fullModelName = ucfirst(end($name_arr));

        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true);
        }

        $this->files = new Filesystem();
        $this->composer = new Composer($this->files);
        $this->date = date('Y-m-d');
        $this->time = date('H:i');

        $stub = $this->files->get($this->getStub());
        $nameSpace = str_replace('/', '\\', $path);
        $templateData = [
            'date' => $this->date,
            'time' => $this->time,
            'className' => $fullModelName . 'Service',
            'nameSpace' => $nameSpace,
        ];
        $renderStub = $this->getRenderStub($templateData, $stub);
        $path .= DIRECTORY_SEPARATOR . $fullModelName . 'Service.php';
        if (!$this->files->exists($path)) {
            $this->files->put($path, $renderStub);
            $filename = substr(strrchr($path, "/"), 1);
            $this->info('create : ' . $filename . '  success');
        } else {
            $filename = substr(strrchr($path, "/"), 1);
            $this->info('The file : ' . $filename . '  already exists');
        }

        return true;
    }

    protected function getRenderStub($templateData, $stub)
    {
        foreach ($templateData as $search => $replace) {
            $stub = str_replace('$' . $search, $replace, $stub);
        }

        return $stub;
    }

    protected function getStub()
    {
        $stubPath = dirname(__DIR__) . '/stubs/Service.stub';

        return $stubPath;
    }
}