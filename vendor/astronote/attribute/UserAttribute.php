<?php

trait UserAttribute 
{
    function __construct($attributes = array())
    {
        parent::__construct($attributes);

        $this->appends = [
            'firebase',
        ];
    }

    public function getFirebaseAttribute(){
        return date('Y-m-d H:i:s');
    }
}