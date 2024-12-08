<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DevSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '設定開發環境';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        system('php artisan db:wipe && php artisan migrate && php artisan db:seed && php artisan cache:clear');
    }
}
