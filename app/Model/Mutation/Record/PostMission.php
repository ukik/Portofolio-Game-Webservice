<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostMission extends Model
{
  
    protected $table = 'mutation_record_mission';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
	    'uuid',
      'code_user',
      'code_mission',
      'code_tools_vehicle',
      'code_this',
      'date',
      'key_title',
      'title',
      'mode',
      'difficulty',
      'premium',
      'normal',
      'package',
      'cash',
      'coin',
      'score',
	    'done',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];
}
