<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class PostUser extends Model
{
    
    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
      'id',
      'code_user',
      'password',
      'remember_token',
      'name',
      'email',
      'address',
      'phone',
      'plain',
      'token',
      'refresh',
      'scope',
      'api',
      'claim',
      'protocol',
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

      'verification',
      'created_at',
      'updated_at',
      'deleted_at'
    ];
    
    protected $table = 'user';
	
}
