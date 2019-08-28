<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [

        # call when register done
        'RegisterEvent' => [
            'RegisterSender',
            // 'RegisterEmail',
        ],

        # call when user ask forget email
        'ForgetEvent' => [
            'ForgetSender',
            // 'ForgetEmail',
        ],

        # call when user login
        'LoginEvent' => [
            'LoginSender',
        ],

        // 'ResetEvent' => [
        //     'ResetSender',
        // ],

        # call when mission is taken
        'MissionEvent' => [
            'MissionSender',
        ],

        # call when game is done
        'GameEvent' => [
            'GameSender',
        ],

        # call when tool is purchased
        'ToolsEvent' => [
            'ToolsSender',
        ],

        # call when vehicle is purchased
        'VehicleEvent' => [
            'VehicleSender',
        ],

        # call when user purchased cash/coin
        'PurchaseEvent' => [
            'PurchaseSender',
            // 'PurchaseEmail',
        ],

        # call when user withdrawn 
        'WithdrawEvent' => [
            'WithdrawSender',
            // 'WithdrawEmail',
        ],

        # call when data must be record to table wallet & table summary
        'WalletSummaryEvent' => [
            'WalletSender',
            'SummarySender',
        ]

    ];

    public function boot()
    {
        parent::boot();
    }
}
