<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostVehicleMeter extends Model
{
    protected $table = 'library_vehicle_meter';

    protected $primaryKey = 'id';

    protected $fillable = [
      'uuid',
      'code_vehicle',
      'meter_power',
      'meter_tank',
      'meter_capacity',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
