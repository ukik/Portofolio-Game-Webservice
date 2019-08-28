<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        '\AllTask',
        '\ActivityTask',
        '\AuthTask',
        '\EmailTask'
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('fire:all')->everyMinute()->withoutOverlapping();  
        //$schedule->command('fire:auth')->everyMinute()->withoutOverlapping();  
        //$schedule->command('fire:activity')->everyMinute()->withoutOverlapping(); 
        //$schedule->command('fire:email')->everyMinute()->withoutOverlapping(); 
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
