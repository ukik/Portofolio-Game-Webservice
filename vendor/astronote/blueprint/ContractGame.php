<?php

interface ContractGame {
    
    public function setTotalComplainAttribute($value = 0);
    public function setTotalLifeAttribute($value = 0);
    public function setTotalFuelAttribute($value = 0);
    public function setTotalTimeAttribute($value = 0);
    public function setTotalBonusAttribute($value = 0);
    public function setCashAttribute($value = 0);
    public function setCoinAttribute($value = 0);
    public function setScoreAttribute($value);
    
}