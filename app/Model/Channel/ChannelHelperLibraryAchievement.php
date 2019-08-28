<?php

namespace App\Model\Channel;

use Illuminate\Database\Eloquent\Model;

use App\Model\Mutation\Record\GetAchievement;

use AchievementAttribute;

class ChannelHelperLibraryAchievement extends Model
{

    use AchievementAttribute;

    public $incrementing = false;

    protected $primaryKey = 'code_achievement';

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
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title'             => '',
        'code_achievement'  => '',
        'description'       => '',
        'term'              => '',
        'label'             => '',
        'cash'              => '',
        'coin'              => '',
        'score'             => '',
        'target'            => '',
        'status'            => '',
        'created_at'        => '',
        'updated_at'        => '',
        'deleted_at'        => '',
      ];
    }    
    
    public function get_mutation_achievement()
    {
        return $this
              ->belongsTo(GetAchievement::class, 'code_achievement', 'code_achievement')
              ->select(['id','code_user','code_achievement','term','label','status','created_at']);
    }       

}
