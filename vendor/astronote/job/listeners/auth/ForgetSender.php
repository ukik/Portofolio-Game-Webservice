<?php

use Sender;
use ForgetEvent;
use App\Model\User\GetUser as User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetSender # implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Auth';
    
    public function handle(ForgetEvent $event)
    {
        $data = User::
                where('email', $event->target)
                ->orWhere('phone',  $event->target)
                ->first();
        
        try {
            echo $send = new Sender(message('url').'/game-auth-forget.json', ['user' => $data]);       
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }                          
    }
}
