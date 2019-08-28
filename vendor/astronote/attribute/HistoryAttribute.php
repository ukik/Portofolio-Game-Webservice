<?php

trait HistoryAttribute
{

    function __construct($attributes = array())
    {

        parent::__construct($attributes);
        $this->table = getter('table_helper'); 

    }
    
}
