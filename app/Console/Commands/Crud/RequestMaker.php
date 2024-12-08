<?php

namespace App\Console\Commands\Crud;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\ConsoleOutput;

class RequestMaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:request
                            {model_name} Model 名稱
                            {model} 資料表名稱
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立 Crud Request';

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
        $model = $this->argument('model');
        $this->createRequestDirectories($model_name);
        $this->makeEdit($model_name, $model);
        $this->makeCreate($model_name, $model);
        $this->makeUpdate($model_name, $model);
        $this->makeDelete($model_name, $model);
        $this->makeApiGetOne($model_name, $model);
        $this->makeApiGetPage($model_name);
        $this->makeApiPost($model_name);
        $this->makeApiPut($model_name, $model);
        $this->makeApiDelete($model_name, $model);
    }

    public function createRequestDirectories(string $model_name): void
    {
        if (! File::exists(app_path("Http/Requests/Api/{$model_name}"))) {
            File::makeDirectory(app_path("Http/Requests/Api/{$model_name}"), 0755, true);
        }
        if (! File::exists(app_path("Http/Requests/{$model_name}"))) {
            File::makeDirectory(app_path("Http/Requests/{$model_name}"), 0755, true);
        }
    }

    public function makeEdit(string $model_name, string $model): void
    {
        $stub = File::get(base_path('stubs/Crud/request-edit.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ model }}'], [$model_name, $model], $stub);

        $path = app_path("Http/Requests/{$model_name}/Get{$model_name}EditRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id Request Edit 建立完畢: {$path}");
    }

    public function makeCreate(string $model_name, string $model): void
    {
        $stub = File::get(base_path('stubs/Crud/request-create.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ model }}'], [$model_name, $model], $stub);

        $path = app_path("Http/Requests/{$model_name}/Post{$model_name}CreateRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id Request Create 建立完畢: {$path}");
    }

    public function makeUpdate(string $model_name, string $model): void
    {
        $stub = File::get(base_path('stubs/Crud/request-update.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ model }}'], [$model_name, $model], $stub);

        $path = app_path("Http/Requests/{$model_name}/Put{$model_name}UpdateRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id Request Update 建立完畢: {$path}");
    }

    public function makeDelete(string $model_name, string $model): void
    {
        $stub = File::get(base_path('stubs/Crud/request-delete.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ model }}'], [$model_name, $model], $stub);

        $path = app_path("Http/Requests/{$model_name}/Delete{$model_name}DeleteRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id Request Delete 建立完畢: {$path}");
    }

    public function makeApiGetOne(string $model_name, string $model): void
    {
        $stub = File::get(base_path('stubs/Crud/request-api-get.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ model }}'], [$model_name, $model], $stub);

        $path = app_path("Http/Requests/Api/{$model_name}/ApiGet{$model_name}ByIdRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id API Request Get 建立完畢: {$path}");
    }

    public function makeApiGetPage(string $model_name): void
    {
        $stub = File::get(base_path('stubs/Crud/request-api-get-page.stub'));
        $stub = str_replace('{{ model_name }}', $model_name, $stub);

        $path = app_path("Http/Requests/Api/{$model_name}/ApiGet{$model_name}PageRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id API Request Get Page 建立完畢: {$path}");
    }

    public function makeApiPost(string $model_name): void
    {
        $stub = File::get(base_path('stubs/Crud/request-api-post.stub'));
        $stub = str_replace('{{ model_name }}', $model_name, $stub);

        $path = app_path("Http/Requests/Api/{$model_name}/ApiPost{$model_name}CreateRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id API Request Post 建立完畢: {$path}");
    }

    public function makeApiPut(string $model_name, string $model): void
    {
        $stub = File::get(base_path('stubs/Crud/request-api-put.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ model }}'], [$model_name, $model], $stub);

        $path = app_path("Http/Requests/Api/{$model_name}/ApiPut{$model_name}UpdateRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id API Request Put 建立完畢: {$path}");
    }

    public function makeApiDelete(string $model_name, string $model): void
    {
        $stub = File::get(base_path('stubs/Crud/request-api-delete.stub'));
        $stub = str_replace(['{{ model_name }}', '{{ model }}'], [$model_name, $model], $stub);

        $path = app_path("Http/Requests/Api/{$model_name}/ApiDelete{$model_name}DeleteRequest.php");
        File::put($path, $stub);

        $this->info("Crud By Id API Request Delete 建立完畢: {$path}");
    }
}
