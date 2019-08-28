<?php

# dipakai oleh Model
trait RecordGetMissionStatus
{    
    protected static function boot()
    {
        parent::boot();

        if(getter('game') == true){
            static::addGlobalScope(new EnableRecordGetMissionStatus);
        }
    }    
}

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EnableRecordGetMissionStatus implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        // query will result
        # select * from `user` where `user`.`deleted_at` is null and mutation_record_mission.status = "enable"
        $builder->whereRaw('mutation_record_mission.status = "enable"'); # memberikan default value pada query
    }
}

