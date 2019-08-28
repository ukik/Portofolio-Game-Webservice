<?php

trait WalletAttribute
{
    function __construct($attributes = array())
    {
      parent::__construct($attributes);

      $this->appends = [
        'mission_completed',
        'rank_tools_vehicle',
        'rank_activity',
        'rank_complete',
        'rank_premium',
        'rank_normal',
        'rank_score',
      ];
    }

    private $bronze = 7;
    private $silver = 11;
    private $gold = 14;
    private $platinum = 17;
    private $diamond = 21;
    public function getRankToolsVehicleAttribute(){
      if(
        $this->tools_vehicle <= $bronze){
        return 1;
     } else if(
        $this->tools_vehicle >= $bronze && 
        $this->tools_vehicle < $silver){
        return 1; 
      } else if(
        $this->tools_vehicle >= $silver && 
        $this->tools_vehicle < $gold){
        return 2; 
      } else if(
        $this->tools_vehicle >= $gold && 
        $this->tools_vehicle < $platinum){
        return 3; 
      } else if(
        $this->tools_vehicle >= $platinum && 
        $this->tools_vehicle < $diamond){
        return 4; 
      } else if(
        $this->tools_vehicle >= $diamond){
        return 5; 
      }  
    }       

    private $rank_activity_1 = 100 * 2.5;
    private $rank_activity_2 = 250 * 2.5;
    private $rank_activity_3 = 500 * 2.5;
    private $rank_activity_4 = 750 * 2.5;
    private $rank_activity_5 = 1000 * 2.5;
    public function getRankActivityAttribute(){
      if(
        $this->activity < $this->rank_activity_1){
        return 1;
      } else if(
        $this->activity >= $this->rank_activity_1 && 
        $this->activity < $this->rank_activity_2){
        return 2; 
      } else if(
        $this->activity >= $this->rank_activity_2 && 
        $this->activity < $this->rank_activity_3){
        return 3; 
      } else if(
        $this->activity >= $this->rank_activity_3 && 
        $this->activity < $this->rank_activity_4){
        return 4; 
      } else if(
        $this->activity >= $this->rank_activity_4 && 
        $this->activity < $this->rank_activity_5){
        return 5; 
      } else if(
        $this->activity >= $this->rank_activity_5){
        return 6; 
      }  
    }       

    private $rank_complete_1 = 2500 * 1.5;
    private $rank_complete_2 = 5000 * 1.5;
    private $rank_complete_3 = 7500 * 1.5;
    private $rank_complete_4 = 10000 * 1.5;
    private $rank_complete_5 = 20000 * 1.5;
    public function getRankCompleteAttribute(){
      if(
        $this->complete < $this->rank_complete_1){
        return 1;
      } else if(
        $this->complete >= $this->rank_complete_1 && 
        $this->complete < $this->rank_complete_2){
        return 2; 
      } else if($this->complete >= $this->rank_complete_2 && 
        $this->complete < $this->rank_complete_3){
        return 3; 
      } else if($this->complete >= $this->rank_complete_3 && 
        $this->complete < $this->rank_complete_4){
        return 4; 
      } else if($this->complete >= $this->rank_complete_4 && 
        $this->complete < $this->rank_complete_5){
        return 5; 
      } else if(
        $this->complete >= $this->rank_complete_5){
        return 6; 
      }  
    } 

    private $rank_premium_1 = 2500;
    private $rank_premium_2 = 5000;
    private $rank_premium_3 = 7500;
    private $rank_premium_4 = 10000;
    private $rank_premium_5 = 20000;
    public function getRankPremiumAttribute(){
      if(
        $this->premium < $this->rank_premium_1){
        return 1;
      } else if(
        $this->premium >= $this->rank_premium_1 && 
        $this->premium < $this->rank_premium_2){
        return 2; 
      } else if(
        $this->premium >= $this->rank_premium_2 && 
        $this->premium < $this->rank_premium_3){
        return 3; 
      } else if(
        $this->premium >= $this->rank_premium_3 && 
        $this->premium < $this->rank_premium_4){
        return 4; 
      } else if(
        $this->premium >= $this->rank_premium_4 && 
        $this->premium < $this->rank_premium_5){
        return 5; 
      } else if(
        $this->premium >= $this->rank_premium_5){
        return 6; 
      }  
    }     

    private $rank_normal_1 = 2500 * 1.75;
    private $rank_normal_2 = 5000 * 1.75;
    private $rank_normal_3 = 7500 * 1.75;
    private $rank_normal_4 = 10000 * 1.75;
    private $rank_normal_5 = 20000 * 1.75;
    public function getRankNormalAttribute(){
      if(
        $this->normal < $this->rank_normal_1){
        return 1;
      } else if(
        $this->normal >= $this->rank_normal_1 && 
        $this->normal < $this->rank_normal_2){
        return 2; 
      } else if(
        $this->normal >= $this->rank_normal_2 && 
        $this->normal < $this->rank_normal_3){
        return 3; 
      } else if(
        $this->normal >= $this->rank_normal_3 && 
        $this->normal < $this->rank_normal_4){
        return 4; 
      } else if(
        $this->normal >= $this->rank_normal_4 && 
        $this->normal < $this->rank_normal_5){
        return 5; 
      } else if(
        $this->normal >= $this->rank_normal_5){
        return 6; 
      }  
    }     

    private $rank_score_1 = 2500 * 2;
    private $rank_score_2 = 5000 * 2;
    private $rank_score_3 = 7500 * 2;
    private $rank_score_4 = 10000 * 2;
    private $rank_score_5 = 20000 * 2;
    public function getRankScoreAttribute(){
      if(
        $this->score_in < $this->rank_score_1){
        return 1;
      } else if(
        $this->score_in >= $this->rank_score_1 && 
        $this->score_in < $this->rank_score_2){
        return 2; 
      } else if(
        $this->score_in >= $this->rank_score_2 && 
        $this->score_in < $this->rank_score_3){
        return 3; 
      } else if(
        $this->score_in >= $this->rank_score_3 && 
        $this->score_in < $this->rank_score_4){
        return 4; 
      } else if(
        $this->score_in >= $this->rank_score_4 && 
        $this->score_in < $this->rank_score_5){
        return 5; 
      } else if(
        $this->score_in >= $this->rank_score_5){
        return 6; 
      }  
    }  

    public function getMissionCompletedAttribute(){
      return $this->premium + $this->normal;  
    }    

    public function setActivityAttribute($value){
      $this->attributes['activity'] = $this->activity + $value;
    }

    public function setCompleteAttribute($value){
      # jika misi 'complete' maka auto 'failed'
      $this->attributes['failed']   = $this->failed - $value;
      $this->attributes['complete'] = $this->complete + $value;
    }

    public function setFailedAttribute($value){
      $this->attributes['failed'] = $this->failed + $value;
    }

    public function setPremiumAttribute($value){
      $this->attributes['premium'] = $this->premium + $value;
    }
    
    public function setNormalAttribute($value){
      $this->attributes['normal'] = $this->normal + $value;
    }

    public function setCashInAttribute($value){
      $this->attributes['cash_in'] = $this->cash_in + $value;
    }

    public function setCashOutAttribute($value){
      $this->attributes['cash_out'] = $this->cash_out - $value;      
    }

    public function setCoinInAttribute($value){
      $this->attributes['coin_in'] = $this->coin_in + $value;      
    }

    public function setCoinOutAttribute($value){
      $this->attributes['coin_out'] = $this->coin_out - $value;      
    }    

    public function setBonusInAttribute($value){
      $this->attributes['bonus_in'] = $this->bonus_in + $value;      
    }    

    public function setScoreInAttribute($value){
      $this->attributes['score_in'] = $this->score_in + $value;      
    }    

}
