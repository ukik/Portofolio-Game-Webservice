<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

use VehicleAttribute;

use ContractVehicle;

use GameStatus;

class GetVehicle extends Model implements ContractVehicle
{

    use GameStatus;
        
    use VehicleAttribute;

    protected $table = 'library_vehicle';

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [
        'code_vehicle',
        'title',
        'package',
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
        'title',
        'package',
        'level',
        'name',
        'description',
        'cash',
        'coin',
        'discount',
        'health',
        'fuel',
        'slot',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function initialize()
    {
        return [
            'title'         => '',
            'package'       => '',
            'level'         => '',
            'name'          => '',
            'description'   => '',
            'cash'          => '',
            'coin'          => '',
            'discount'      => '',
            'health'        => '',
            'fuel'          => '',
            'slot'          => '',
            'status'        => '',
            'created_at'    => '',
            'updated_at'    => '',
            'deleted_at'    => '',
        ];
    }

    public function get_vehicle_meter()
    {
        return $this->hasOne(GetVehicleMeter::class, 'code_vehicle', 'code_vehicle')
          ->select(['code_vehicle','meter_power','meter_tank','meter_capacity']);
    }         

}
