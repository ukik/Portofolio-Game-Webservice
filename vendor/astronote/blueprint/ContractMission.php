<?php

interface ContractMission {
    
    public function ToolsVehicleLevel();
    public function getGameSettingAttribute();
    public function getToolsVehicleAttribute ();
    public function getTimeSettingAttribute();
    public function getTimeWaitingAttribute();
    public function getGameTimeAttribute();
    public function getGameTimeValueAttribute();
    public function getGameLifeValueAttribute();
    public function getGameFuelValueAttribute();
    public function getGameComplainValueAttribute();
    public function getBonusValueAttribute();
    public function getGameDurationAttribute();
    public function getPlayerLabelAttribute();
    public function getPlayerSpeedAttribute();
    public function getPlayerMaxSpeedAttribute();
    public function getPlayerDamageAttribute();
    public function getPlayerFrictionAttribute();
    public function getModeAttribute($value);
    public function getDifficultyAttribute();
    public function getPremiumAttribute();
    public function getNormalAttribute();
    public function setCashAttribute($value = 0);
    public function setCoinAttribute($value = 0);
    public function setScoreAttribute($value = 0);

}