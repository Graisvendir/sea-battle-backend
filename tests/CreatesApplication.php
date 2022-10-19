<?php

namespace Tests;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{

    /**
     * Creates the application.
     *
     * @return Application
     * @throws \Exception
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // конфиг, в какую бд мигрировать в файле phpunit.xml
        $result = Artisan::call('migrate');

        if ($result !== Command::SUCCESS) {
            throw new \Exception('migration is not success');
        }

        return $app;
    }
}
