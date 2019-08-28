<?php

use Illuminate\Console\Command;

class AllTask extends Command
{

    protected $signature = 'fire:all';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Artisan::call('queue:listen', [
        //     '--queue' => 'auth,activity,email',
        //     '--tries' => 1,
        //     '--timeout' => 120
        // ]);

        Artisan::call('queue:work', [
            '--queue' => 'auth,activity,email',
            '--tries' => 1,
            '--timeout' => 120,
            '--daemon' => '',
            '&'
        ]);
    }
}
