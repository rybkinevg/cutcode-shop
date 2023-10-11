<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'shop:install';
    protected $description = 'Installs the application';

    public function handle(): int
    {
        $this->call('storage:link');
        $this->call('migrate');

        return self::SUCCESS;
    }
}
