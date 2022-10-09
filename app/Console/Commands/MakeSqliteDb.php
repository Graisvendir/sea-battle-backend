<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class MakeSqliteDb extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sqlite-db {db-connection=sqlite_test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make sqlite DB. Need for tests';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $dbConnection = $this->argument('db-connection');
        $config = config('database.connections.' . $dbConnection);
        $database = $config['database'] ?? '';

        if (!$database) {
            $this->error('DB path for DB connection "' . $dbConnection . '" is not exist');

            return Command::FAILURE;
        }

        if (file_exists($database)) {
            $this->info('DB for DB connection "' . $dbConnection . '" is already exist');

            return Command::SUCCESS;
        }

        $db = new \SQLite3($database);

        if (!$db) {
            $this->error('DB for DB connection "' . $dbConnection . '" is not created');

            return Command::FAILURE;
        }

        $this->info('DB for DB connection "' . $dbConnection . '" is created');

        return Command::SUCCESS;
    }
}
