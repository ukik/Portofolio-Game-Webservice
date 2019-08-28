<?php

namespace App\Model\Channel;

use App\Model\Library\GetVehicleMeter;
use Illuminate\Database\Eloquent\Model;
use DB;

class ChannelHelperMutationToolsVehicle extends Model
{

    protected $table = 'channel_helper_mutation_tools_vehicle';

    public $incrementing = false;

    protected $primaryKey = 'code_user';

    protected $guarded = [
        'code_user',
        'code_tools_vehicle',
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
        'mode',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'code_user',
        'code_tools_vehicle',
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
        'mode',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function initialize()
    {
        return [
            'code_user'         => '',
            'code_tools_vehicle'=> '',
            'code_this'         => '',
            'package'           => '',
            'title'             => '',
            'level'             => '',
            'name'              => '',
            'description'       => '',
            'cash'              => '',
            'coin'              => '',
            'discount'          => '',
            'health'            => '',
            'fuel'              => '',
            'status'            => '',
            'slot'              => '',
            'mode'              => '',
            'created_at'        => '',
            'updated_at'        => '',
            'deleted_at'        => '',
        ];
    }

    public function get_vehicle_meter()
    {
        return $this->hasOne(GetVehicleMeter::class, 'code_vehicle', 'code_tools_vehicle')
            ->select(['code_vehicle', 'meter_power', 'meter_tank', 'meter_capacity']);
    }
    
    // public function scopeTotalSlot($query, $mode)
    // {
    //     return $query->whereMode($mode)->select(DB::raw('Sum(`slot`) AS `slot`'))->get();
    // }

    // public function scopeTotalSlotService($query, $mode)
    // {
    //     return $query->wherePackage($mode)->select(DB::raw('Sum(`slot`) AS `slot`'))->get();
    // }    
}
