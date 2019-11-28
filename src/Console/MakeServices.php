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
        $fullModelName = $this->argument('modelName');

        $fullModelName = ucfirst($fullModelName);

        if (!$this->files->isDirectory(self::SERVICE_PATH)) {
            $this->files->makeDirectory(self::SERVICE_PATH, 0755, true);
        }
        $this->files = new Filesystem();
        $this->composer = new Composer($this->files);
        $this->date = date('Y-m-d');
        $this->time = date('H:i');

        $path = self::SERVICE_PATH . DIRECTORY_SEPARATOR . $fullModelName . 'Service.php';


        $stub = $this->files->get($this->getStub());
        $nameSpace = str_replace('/', '\\', self::SERVICE_PATH);
        $templateData = [
            'date' => $this->date,
            'time' => $this->time,
            'className' => $fullModelName . 'Service',
            'nameSpace' => $nameSpace,
        ];
        $renderStub = $this->getRenderStub($templateData, $stub);
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