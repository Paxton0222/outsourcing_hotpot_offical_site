<?php

namespace App\Console\Commands\Crud;

use AllowDynamicProperties;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

#[AllowDynamicProperties] class CrudMaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud
                            {model_name} Model 名稱
                            {model} 資料表名稱
                            {route} 路由前綴
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立CRUD後台頁面';

    public function __construct(RepositoryMaker $repo, ServiceMaker $service, ControllerMaker $controller, RequestMaker $request, RouteMaker $route, PageMaker $page)
    {
        parent::__construct();
        $this->repo = $repo;
        $this->service = $service;
        $this->controller = $controller;
        $this->request = $request;
        $this->route = $route;
        $this->page = $page;
        $this->output = new ConsoleOutput;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $model_name = $this->argument('model_name');
        $model = $this->argument('model');
        $route = $this->argument('route');
        $this->repo->makeRepository($model_name);
        $this->service->makeService($model_name);
        $this->controller->makeInertia($model_name, $route);
        $this->controller->makeApi($model_name);
        $this->request->createRequestDirectories($model_name);
        $this->request->makeEdit($model_name, $model);
        $this->request->makeCreate($model_name, $model);
        $this->request->makeUpdate($model_name, $model);
        $this->request->makeDelete($model_name, $model);
        $this->request->makeApiGetOne($model_name, $model);
        $this->request->makeApiGetPage($model_name);
        $this->request->makeApiPost($model_name);
        $this->request->makeApiPut($model_name, $model);
        $this->request->makeApiDelete($model_name, $model);
        $this->route->makeWebRoute($model_name, $route);
        $this->route->makeApiRoute($model_name, $route);
        $this->page->makeModalType($model_name, $route);
        $this->page->makeTable($model_name, $route);
    }
}
