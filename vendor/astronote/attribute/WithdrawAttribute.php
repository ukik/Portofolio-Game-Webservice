<?php

trait WithdrawAttribute
{
    function __contruct($attributes = array())
    {
        parent::__construct($attributes);

        $this->appends = [
            'cash_fee',
            'coin_fee'
        ]; 
    }

    public function getCashFeeAttribute()
    {
        return ($this->cash + (($this->cash * $this->fee)/100));
    }    

    public function getCoinFeeAttribute()
    {
        return ($this->coin + (($this->coin * $this->fee)/100));
    }    

}

  