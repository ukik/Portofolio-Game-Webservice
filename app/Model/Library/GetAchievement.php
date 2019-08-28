<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

use App\Model\Mutation\Record\GetAchievement as MutationGetAchievement;

use GameStatus;

class GetAchievement extends Model
{
  
    use GameStatus;

    protected $table = 'library_achievement';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_achievement',
      'title',
      'description',
      'term',
      'label',
      'cash',
      'coin',
      'score',
      'target',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'title',
      'description',
      'term',
      'label',
      'cash',
      'coin',
      'score',
      'target',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];
    
    public static function initialize()
    {
      return [
        'title'       => '',
        'description' => '',
        'term'        => '',
        'label'       => '',
        'cash'        => '',
        'coin'        => '',
        'score'       => '',
        'target'      => '',
        'status'      => '',
        'created_at'  => '',
        'updated_at'  => '',
        'deleted_at'  => '',
      ];
    }    

    public function get_mutation_achievement()
    {
        return $this
              ->belongsTo(MutationGetAchievement::class, 'code_achievement', 'code_achievement')
              ->select(['id','code_user','code_achievement','term','label','status','created_at']);
    }       
    
}
