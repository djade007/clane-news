<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetUpProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the whole project';

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
     * @return mixed
     */
    public function handle()
    {
        $this->comment("Setting Up Project.....");

        $this->call('key:generate');
        $this->call('jwt:secret');
        $this->call("migrate:refresh", ['--seed' => true, '--force' => true]);

        $this->info("Project set up completed");
    }
}
