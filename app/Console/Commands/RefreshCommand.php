<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{

    protected $signature = 'shop:refresh';


    protected $description = 'Refresh';

    public function handle(): int
    {
        if (app()->isProduction()) {
            $this->warn('This command cannot be run in production environment!');
            return self::SUCCESS;
        }
        $this->info('удаление папки если есть');
        if (Storage::exists('images/products')) {
            Storage::deleteDirectory('images/products');
        }

        try {
            $this->info('refres и seeding...');
            Storage::createDirectory('images/products');
            $this->call('migrate:fresh', [
                '--seed' => true,
            ]);
            $this->info('всё прошло');
            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Command failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
