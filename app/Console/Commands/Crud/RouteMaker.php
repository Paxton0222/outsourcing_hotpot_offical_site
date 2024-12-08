<?php

namespace App\Console\Commands\Crud;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\ConsoleOutput;

class RouteMaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:route
                            {model_name} Model 名稱
                            {route} 路由前綴
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立 Crud 路由';

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
        $this->makeWebRoute($model_name, $route);
        $this->makeApiRoute($model_name, $route);
    }

    public function makeWebRoute(string $model_name, string $route): void
    {
        $stub = File::get(base_path('stubs/Crud/web-route.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ route }}'], [$model_name, $route], $stub);

        // 將最終的檔案內容寫入到指定路徑
        $path = base_path('routes/web.php');

        File::append($path, $stub);

        $this->info('Crud By Id web route 建立完畢');
    }

    public function makeApiRoute(string $model_name, string $route): void
    {
        $stub = File::get(base_path('stubs/Crud/api-route.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ route }}'], [$model_name, $route], $stub);

        // 將最終的檔案內容寫入到指定路徑
        $path = base_path('routes/api.php');

        File::append($path, $stub);

        $this->info('Crud By Id api route 建立完畢');
    }
}
