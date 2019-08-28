<?php

interface ContractSummary {

    public function getMissionCompletedAttribute();
    public function setActivityAttribute($value);
    public function setCompleteAttribute($value);
    public function setFailedAttribute($value);
    public function setPremiumAttribute($value);
    public function setNormalAttribute($value);
    public function setCashInAttribute($value);
    public function setCashOutAttribute($value);
    public function setCoinInAttribute($value);
    public function setCoinOutAttribute($value);
    public function setBonusInAttribute($value);
    public function setScoreInAttribute($value);    
    public function getRankToolsVehicleAttribute();
    public function getRankActivityAttribute();
    public function getRankCompleteAttribute();
    public function getRankPremiumAttribute();
    public function getRankNormalAttribute();

}