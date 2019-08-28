<?php

use WithdrawEvent;
use App\Model\User\GetUser as User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawEmail # implements ShouldQueue
{
    use InteractsWithQueue; 

    public $connection = 'Email';    

    public function handle(WithdrawEvent $event)
    {
        $data = User::
                where('email', $event->target)
                ->orWhere('phone', $event->target)
                ->first();

        setter('event', $event);
        setter('email', $data['email']);
        
        Mail::send('emails.withdraw', ['user' => $data], function($message)
        {
            $event = getter('event');
            $message
                ->from(email())
                ->to($event->target, "Game Pesanbungkus > ".$user->name)
                ->subject($event->subject);
        });        
    }
}
