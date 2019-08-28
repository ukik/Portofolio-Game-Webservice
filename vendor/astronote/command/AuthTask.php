<?php

use Illuminate\Console\Command;

class AuthTask extends Command
{

    protected $signature = 'fire:auth';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Artisan::call('queue:listen', [
        //     '--queue' => 'auth',
        //     '--tries' => 1,
        //     '--timeout' => 120
        // ]);

        Artisan::call('queue:work', [
            '--queue' => 'auth',
            '--tries' => 1,
            '--timeout' => 120,
            '--daemon' => '',
            '&'
        ]);               
    }
}
