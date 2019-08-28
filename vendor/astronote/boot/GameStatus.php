<?php

# dipakai oleh Model
trait GameStatus
{    
    protected static function boot()
    {
        parent::boot();

        if(getter('game') == true){
            static::addGlobalScope(new EnableGameStatus);
        }
    }    
}

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EnableGameStatus implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        // query will result 
        # select * from `user` where `user`.`deleted_at` is null and `status` = ? 
        // $builder->whereStatus('enable'); 
        
        // query will result
        # select * from `user` where `user`.`deleted_at` is null and status = "enable"
        $builder->whereRaw('status = "enable"'); # memberikan default value pada query
    }
}