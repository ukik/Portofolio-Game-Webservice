<?php

trait VehicleAttribute 
{

    function __contruct($attributes = array()) 
    {
        parent::__contruct($attributes);
        
        $this->appends = [
            'meter_power',
            'meter_tank',
            'meter_capacity'
        ];
       
    }

    public function getMeterPowerAttribute(){
        return $this->get_vehicle_meter->meter_power;
    }

    public function getMeterTankAttribute(){
        return $this->get_vehicle_meter->meter_tank;
    }

    public function getMeterCapacityAttribute(){
        return $this->get_vehicle_meter->meter_capacity;
    }
        
}