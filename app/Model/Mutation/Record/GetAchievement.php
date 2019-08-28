<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

use App\Model\User\GetUser;

use App\Model\Mutation\Record\GetAchievement;

use GameStatus;

class GetAchievement extends Model
{

    use GameStatus;

    protected $table = 'mutation_record_achievement';

    public $incrementing = false;

    protected $primaryKey = 'code_user';
    
    protected $guarded = [
      'id',
      'code_user',
      'code_achievement',
      'title',
      'description',
      'term',
      'label',
      'cash',
      'coin',
      'target',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id',
      'code_user',
      'code_achievement',
      'title',
      'description',
      'term',
      'label',
      'cash',
      'coin',
      'target',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',

      'get_user_profile.id',
      'get_user_profile.code_user',
      'get_user_profile.name',
      'get_user_profile.email',
      'get_user_profile.address',
      'get_user_profile.phone',
      'get_user_profile.scope',
      'get_user_profile.status',
      'get_user_profile.created_at',
      'get_user_profile.updated_at',        
    ];

    public static function initialize()
    {
      return [
        'id'                => '',
        'code_user'         => '',
        'code_achievement'  => '',
        'title'             => '',
        'description'       => '',
        'term'              => '',
        'label'             => '',
        'cash'              => '',
        'coin'              => '',
        'target'            => '',
        'status'            => '',
        'created_at'        => '',
        'updated_at'        => '',
        'deleted_at'        => '',

        'get_user_profile.id'         => '',
        'get_user_profile.code_user'  => '',
        'get_user_profile.name'       => '',
        'get_user_profile.email'      => '',
        'get_user_profile.address'    => '',
        'get_user_profile.phone'      => '',
        'get_user_profile.scope'      => '',
        'get_user_profile.status'     => '',
        'get_user_profile.created_at' => '',
        'get_user_profile.updated_at' => '',             
      ];
    }    

    public function get_user_profile()
    {
        return $this->hasOne(GetUser::class, 'code_user');
    } 

}
