<?php

use Sender;
use RegisterEvent;
use App\Model\User\GetUser as User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterSender # implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Auth';
    
    public function handle(RegisterEvent $event)
    {
        $data = User::
                where('email', $event->target)
                ->orWhere('phone',  $event->target)
                ->first();

        try {
            echo $send = new Sender(message('url').'/game-auth-register.json', ['user' => $data]);       
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }                          
    }
}
