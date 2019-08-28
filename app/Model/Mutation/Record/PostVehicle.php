<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostVehicle extends Model
{
    protected $table = 'mutation_record_vehicle';
    
    protected $primaryKey = 'id';

    protected $fillable = [
      'code_user',
      'code_vehicle',
      'code_this',
      'package',
      'title',
      'level',
      'name',
      'description',
      'cash',
      'coin',
      'discount',
      'health',
      'fuel',
      'status',
      'slot',
      'created_at',            
      'updated_at',                 
    ];

    protected $dates = ['deleted_at'];

}
