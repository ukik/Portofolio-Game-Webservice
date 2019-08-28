<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Model\User\GetWallet;
use App\Model\User\GetSummary;

use AuthAttribute;

use ContractAuth;

use GameStatus;

class User extends Authenticatable implements ContractAuth
{
    use GameStatus;
    
    use AuthAttribute;
    
    public $incrementing = false;
    
    protected $primaryKey = 'code_user';	
	
    protected $fillable = [
        'id',
        'name',
        'status',
        'password',
        'plain',
        'email',
        'address',
        'phone',
        'code_user',
        'remember_token',
        'token',
        'scope',
        'api',
        'claim',
        'protocol',
        'visit_driver',
        'visit_service',
        'slot_driver',
        'slot_service',
        'verification',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $table = 'user';

    public function wallet()
    {
        return $this->hasOne(GetWallet::class, 'code_user');
    } 	

    public function summary()
    {
        return $this->hasOne(GetSummary::class, 'code_user');
    }         
  
}


