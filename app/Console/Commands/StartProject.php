<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all commands to start the best project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running all commands...');

        // List your artisan commands
        $commands = [
            'app:create-data-base',
            'migrate',
            'db:seed',
            // 'cache:clear',
            // 'config:cache',
            // 'route:cache',
            // 'view:cache',
        ];

        // Execute all commands
        foreach ($commands as $command) {
            $this->call($command);
        }

        $this->info('Commands executed successfully!');
    }
}
