<?php

use Sender;
use VehicleEvent;
use App\Model\User\GetUser as User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VehicleSender # implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Activity';
    
    public function handle(VehicleEvent $event)
    {
        $data = User::whereCodeUser($event->target)->first();
                
        // $data = ['user' => $user, 'payload' => $event->payload[0]];

        try {
            echo $send = new Sender(message('url').'/game-activity-vehicle.json', ['user' => $data]);      
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }
    }
}