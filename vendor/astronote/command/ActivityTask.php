<?php

use Illuminate\Console\Command;

class ActivityTask extends Command
{

    protected $signature = 'fire:activity';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Artisan::call('queue:listen', [
        //     '--queue' => 'activity',
        //     '--tries' => 1,
        //     '--timeout' => 120
        // ]);

        Artisan::call('queue:work', [
            '--queue' => 'activity',
            '--tries' => 1,
            '--timeout' => 120,
            '--daemon' => '',
            '&'
        ]);        
    }
}
