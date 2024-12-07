<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dbName = $this->argument('name');

        try {
            // Use raw PDO to bypass default database connection
            $pdo = new \PDO(
                "mysql:host=" . env('DB_HOST') . ";port=" . env('DB_PORT'),
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            );

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

            $this->info("Database `$dbName` created successfully!");
        } catch (\Exception $e) {
            $this->error('Error creating database: ' . $e->getMessage());
        }

        return 0;
    }
}
