<?php

use Sender;
use MissionEvent;
use App\Model\User\GetUser as User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MissionSender # implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Activity';
    
    public function handle(MissionEvent $event)
    {
        $data = User::whereCodeUser($event->target)->first();
                
        // $data = ['user' => $user, 'payload' => $event->payload[0]];

        try {
            echo $send = new Sender(message('url').'/game-activity-mission.json', ['user' => $data]);      
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }
    }
}

