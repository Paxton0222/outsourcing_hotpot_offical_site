<?php

namespace App\Console\Commands\Crud;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\ConsoleOutput;

class ControllerMaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:controller
                            {model_name} Model 名稱
                            {route} 路由前綴
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立 Crud Controller';

    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $model_name = $this->argument('model_name');
        $route = $this->argument('route');
        $this->makeInertia($model_name, $route);
        $this->makeApi($model_name);
    }

    public function makeInertia(string $model_name, string $route): void
    {
        $stub = File::get(base_path('stubs/Crud/controller-inertia.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ route }}'], [$model_name, $route], $stub);

        // 將最終的檔案內容寫入到指定路徑
        $path = app_path("Http/Controllers/{$model_name}Controller.php");
        File::put($path, $stub);

        $this->info("Crud By Id Controller 建立完畢: {$path}");
    }

    public function makeApi(string $model_name): void
    {
        $stub = File::get(base_path('stubs/Crud/controller-api.stub'));
        $stub = str_replace('{{ model_name }}', $model_name, $stub);

        // 將最終的檔案內容寫入到指定路徑
        $path = app_path("Http/Controllers/Api/{$model_name}ApiController.php");
        File::put($path, $stub);

        $this->info("Crud By Id Controller API 建立完畢: {$path}");
    }
}
