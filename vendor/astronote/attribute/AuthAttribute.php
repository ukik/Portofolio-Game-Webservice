<?php

use Illuminate\Notifications\Notifiable;

# Passport
use Laravel\Passport\HasApiTokens;

use Carbon;

trait AuthAttribute
{
    use HasApiTokens, Notifiable;
        
    protected $current_time;
    protected $visit_driver_text;
    protected $visit_service_text;
    
    function __construct($attributes = array())
    {
        parent::__construct($attributes);
    
        $this->current_time = Carbon\Carbon::
            now(new \DateTimeZone('Asia/Makassar'))
            ->addHour(0)->format('H:m:s');  
    
        $this->visit_driver_refresh;
        $this->visit_service_refresh;            
    
        $this->appends = [
            'visit_driver_refresh',
            'visit_service_refresh',
            'visit_driver_text',
            'visit_service_text',
        ];
    
    }
    
    public function getVisitDriverTextAttribute($value){
        return $this->visit_driver_text;
    }
    
    public function getVisitServiceTextAttribute($value){
        return $this->visit_service_text;
    }
    
    public function getVisitDriverRefreshAttribute(){
        
        $current_time = $this->current_time;
    
        $visit = "";
    
        if ($current_time < '06:00:00' && $current_time > '00:00:00') {
            $visit = 'driver_malam_pagi';
            $wait = round(Calculation_Now_Second($current_time, '06:00:00'));
            if ($this->visit_driver != $visit) {
                $this->visit_driver_text = $visit;
                return false;
            }
        } else if ($current_time < '12:00:00' && $current_time > '06:00:00') {
            $visit = 'driver_pagi_siang';
            $wait = round(Calculation_Now_Second($current_time, '12:00:00'));
            if ($this->visit_driver != $visit) {
                $this->visit_driver_text = $visit;
                return false;
            }
        } else if ($current_time < '18:00:00' && $current_time > '12:00:00') {
            $visit = 'driver_siang_petang';
            $wait = round(Calculation_Now_Second($current_time, '18:00:00'));
            if ($this->visit_driver != $visit) {
                $this->visit_driver_text = $visit;
                return false;
            }
        } else if ($current_time < '23:59:59' && $current_time > '18:00:00') {
            $visit = 'driver_petang_malam';
            $wait = round(Calculation_Now_Second($current_time, '23:59:59'));
            if ($this->visit_driver != $visit) {
                $this->visit_driver_text = $visit;
                return false;
            }
        }
    
        if ($this->visit_driver == NULL) {
            $this->visit_driver_text = $visit;
            return false;
        }        
    
        return true;
    }
    
    public function getVisitServiceRefreshAttribute(){
        
        $current_time = $this->current_time;
    
        $visit = "";

        $date = '_'.date('d-m-Y');
    
        if ($current_time < '06:00:00' && $current_time > '00:00:00') {
            $visit = 'service_malam_pagi'.$date;
            $wait = round(Calculation_Now_Second($current_time, '06:00:00'));
            if ($this->visit_service != $visit) {
                $this->visit_service_text = $visit;
                return false;
            }
        } else if ($current_time < '12:00:00' && $current_time > '06:00:00') {
            $visit = 'service_pagi_siang'.$date;
            $wait = round(Calculation_Now_Second($current_time, '12:00:00'));
            if ($this->visit_service != $visit) {
                $this->visit_service_text = $visit;
                return false;
            }
        } else if ($current_time < '18:00:00' && $current_time > '12:00:00') {
            $visit = 'service_siang_petang'.$date;
            $wait = round(Calculation_Now_Second($current_time, '18:00:00'));
            if ($this->visit_service != $visit) {
                $this->visit_service_text = $visit;
                return false;
            }
        } else if ($current_time < '23:59:59' && $current_time > '18:00:00') {
            $visit = 'service_petang_malam'.$date;
            $wait = round(Calculation_Now_Second($current_time, '23:59:59'));
            if ($this->visit_service != $visit) {
                $this->visit_service_text = $visit;
                return false;
            }
        }
    
        if ($this->visit_service == NULL) {
            $this->visit_service_text = $visit;
            return false;
        }
    
        return true;
    }      
}


