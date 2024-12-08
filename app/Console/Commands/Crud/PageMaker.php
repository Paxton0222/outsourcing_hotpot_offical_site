<?php

namespace App\Console\Commands\Crud;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\ConsoleOutput;

class PageMaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:page
                            {model_name} Model 名稱
                            {route} 路由前綴
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->makeTable($model_name, $route);
        $this->makeModalType($model_name, $route);
    }

    public function makeTable(string $model_name, string $route): void
    {
        $stub = File::get(base_path('stubs/Crud/frontend/table.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ route }}'], [$model_name, $route], $stub);

        // 將最終的檔案內容寫入到指定路徑
        $path = resource_path("js/Pages/{$model_name}Edit.vue");

        File::put($path, $stub);

        $this->info("Crud By Id table view 建立完畢: {$path}");
    }

    public function makeModalType(string $model_name, string $route): void
    {
        $stub = File::get(base_path('stubs/Crud/frontend/modal-type.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ route }}'], [$model_name, $route], $stub);

        // 將最終的檔案內容寫入到指定路徑
        $path = resource_path('js/types/model.ts');

        File::append($path, $stub);

        $this->info("Crud By Id modal 建立完畢: {$path}");
    }
}
