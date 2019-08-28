<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetVehicleMeter extends Model
{
    protected $table = 'library_vehicle_meter';

    public $incrementing = false;

    protected $primaryKey = 'code_vehicle';

    protected $guarded = [
        'id',
        'uuid',
        'code_vehicle',
        'meter_power',
        'meter_tank',
        'meter_capacity',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'id',
        'uuid',
        'code_vehicle',
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
            'id'             => '',
            'uuid'           => '',
            'code_vehicle'   => '',
            'meter_power'    => '',
            'meter_tank'     => '',
            'meter_capacity' => '',
            'created_at'     => '',
            'updated_at'     => '',
            'deleted_at'     => '',
        ];
    }

}
