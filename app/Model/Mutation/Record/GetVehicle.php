<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

use App\Model\User\GetUser;

use App\Model\Library\GetVehicle as LibraryVehicle;

use GameStatus;

class GetVehicle extends Model
{
    
    use GameStatus;

    protected $table = 'mutation_record_vehicle';
    
    public $incrementing = false;
    
    protected $primaryKey = 'code_user';

    protected $guarded = [
      'id',
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

    protected $filter = [
        'id',
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
        'id'            => '',
        'code_user'     => '',
        'code_vehicle'  => '',
        'code_this'     => '',
        'package'       => '',
        'title'         => '',
        'level'         => '',
        'name'          => '',
        'description'   => '',
        'cash'          => '',
        'coin'          => '',
        'discount'      => '',
        'health'        => '',
        'fuel'          => '',
        'status'        => '',
        'slot'          => '',
        'created_at'    => '',            
        'updated_at'    => '',        

        'get_user_profile.id'           => '',
        'get_user_profile.code_user'    => '',
        'get_user_profile.name'         => '',
        'get_user_profile.email'        => '',
        'get_user_profile.address'      => '',
        'get_user_profile.phone'        => '',
        'get_user_profile.scope'        => '',
        'get_user_profile.status'       => '',
        'get_user_profile.created_at'   => '',
        'get_user_profile.updated_at'   => '',         
      ];
    }        

    public function get_user_profile()
    {
        return $this->hasOne(GetUser::class, 'code_user');
    }

    public function get_library_vehicle()
    {
        return $this
          ->belongsTo(LibraryVehicle::class, 'code_vehicle', 'code_vehicle')
          ->groupBy(['package']);
    }
}
