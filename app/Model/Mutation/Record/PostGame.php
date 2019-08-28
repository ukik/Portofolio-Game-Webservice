<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

use ContractGame;

use GameAttribute;

class PostGame extends Model implements ContractGame
{
    use GameAttribute;

    protected $table = 'mutation_record_game';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
      'code_user',
      'code_game',
      'code_mission',
	  'code_tools_vehicle',
      'title',
      'premium',
      'normal',
      'mode',
      'total_complain',
      'total_life',
      'total_fuel',
      'total_time',
      'total_bonus',
      'cash',
      'score',
      'coin',
      'done',       
      'status',
      'created_at',
      'updated_at',
      'deleted_at',    
    ];

    protected $dates = ['deleted_at'];

    public function get_mission()
    {
        return $this->belongsTo(GetMission::class, 'code_mission', 'uuid');
    }    
}
