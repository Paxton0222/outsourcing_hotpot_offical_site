<?php

namespace App\Console\Commands\Crud;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\ConsoleOutput;

class ServiceMaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:service
                            {model_name} Model 名稱
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立 Crud Service';

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
        $model_name = $this->ask('model_name');
        $this->makeService($model_name);
    }

    public function makeService(string $model_name): void
    {
        $stub = File::get(base_path('stubs/Crud/service.stub'));
        $stub = str_replace('{{ model_name }}', $model_name, $stub);

        // 將最終的檔案內容寫入到指定路徑
        $path = app_path("Services/{$model_name}Service.php");
        File::put($path, $stub);

        $this->info("Crud By Id Service 建立完畢: {$path}");
    }
}
