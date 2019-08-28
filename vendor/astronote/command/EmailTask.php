<?php

use Illuminate\Console\Command;

class EmailTask extends Command
{

    protected $signature = 'fire:email';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Artisan::call('queue:listen', [
        //     '--queue' => 'email',
        //     '--tries' => 1,
        //     '--timeout' => 120
        // ]);

        Artisan::call('queue:work', [
            '--queue' => 'email',
            '--tries' => 1,
            '--timeout' => 120,
            '--daemon' => '',
            '&'
        ]);           
    }
}
