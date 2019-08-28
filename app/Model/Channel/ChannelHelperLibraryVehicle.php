<?php

namespace App\Model\Channel;

use Illuminate\Database\Eloquent\Model;

use App\Model\Library\GetVehicleMeter;
use App\Model\Mutation\Record\PostVehicle;

class ChannelHelperLibraryVehicle extends Model
{

    protected $table = 'channel_helper_library_vehicle';

    public $incrementing = false;

    protected $primaryKey = 'code_vehicle';

    protected $guarded = [
        'code_vehicle',
        'title',
        'package',
        'level',
        'name',
        'description',
        'cash',
        'coin',
        'cash_discount',
        'coin_discount',
        'discount',
        'health',
        'fuel',
        'status',
        'meter_power',
        'meter_tank',
        'meter_capacity',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'id',
        'title',
        'package',
        'level',
        'name',
        'description',
        'cash',
        'coin',
        'cash_discount',
        'coin_discount',
        'discount',
        'health',
        'fuel',
        'status',
        'meter_power',
        'meter_tank',
        'meter_capacity',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function initialize()
    {
        return [
            'title'             => '',
            'package'           => '',
            'level'             => '',
            'name'              => '',
            'description'       => '',
            'cash'              => '',
            'coin'              => '',
            'cash_discount'     => '',
            'coin_discount'     => '',
            'discount'          => '',
            'health'            => '',
            'fuel'              => '',
            'status'            => '',
            'meter_power'       => '',
            'meter_tank'        => '',
            'meter_capacity'    => '',            
            'created_at'        => '',
            'updated_at'        => '',
            'deleted_at'        => '',
        ];
    }
   
    public function get_vehicle_meter()
    {
        return $this->hasOne(GetVehicleMeter::class, 'code_vehicle', 'code_vehicle')
          ->select(['code_vehicle','meter_power','meter_tank','meter_capacity']);
    }         

    public function get_post_vehicles()
    {
        return $this->hasMany(PostVehicle::class, 'code_vehicle', 'code_vehicle');
    }
    
}
