<?php

namespace App\Model\User;

use ContractGetUser;

use Illuminate\Database\Eloquent\Model;

use UserAttribute;

use ContractUser;

use GameStatus;

class GetUser extends Model implements ContractUser
{
    
    use GameStatus;

    use UserAttribute;

    protected $table = 'user';

    public $incrementing = false;

    protected $primaryKey = 'code_user';

    protected $guarded = [
        'id',
        'plain',
        'code_user',
        'name',
        'email',
        'address',
        'phone',
        'scope',
        'status',
        'token',
        'api',
        'claim',
        'protocol',
        'visit_driver',
        'visit_service',

        // 'slot_driver',
        // 'slot_service',

        'slot_driver_motorbox', 
        'slot_driver_motorcycle', 
        'slot_driver_mobil',  
        'slot_driver_pickup',   

        'slot_service_fashion',
        'slot_service_kebersihan',
        'slot_service_pencucian',

        'verification',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'id',
        'code_user',
        'name',
        'email',
        'address',
        'phone',
        'scope',
        'status',
        'visit_driver',
        'visit_service',
        // 'slot_driver',
        // 'slot_service',

        'slot_driver_motorbox', 
        'slot_driver_motorcycle', 
        'slot_driver_mobil',  
        'slot_driver_pickup',           

        'slot_service_fashion',
        'slot_service_kebersihan',
        'slot_service_pencucian',
        
        'created_at',
        'updated_at',
    ];

    public static function initialize()
    {
        return [
            'id'            => '',
            'code_user'     => '',
            'name'          => '',
            'email'         => '',
            'address'       => '',
            'phone'         => '',
            'scope'         => '',
            'status'        => '',
            'verification'  => '',
            'visit_driver'  => '',
            'visit_service' => '',
            
            // 'slot_driver'   => '',
            // 'slot_service'  => '',

            'slot_driver_motorbox'      => '', 
            'slot_driver_motorcycle'    => '', 
            'slot_driver_mobil'         => '',  
            'slot_driver_pickup'        => '',   

            'slot_service_fashion'      => '',
            'slot_service_kebersihan'   => '',
            'slot_service_pencucian'    => '',
    
            'created_at'    => '',
            'updated_at'    => '',
        ];
    }

    public function wallet()
    {
        return $this->hasOne(GetWallet::class, 'code_user');
    } 	    

    public function summary()
    {
        return $this->hasOne(GetSummary::class, 'code_user');
    }     
}
