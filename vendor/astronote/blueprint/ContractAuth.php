<?php

interface ContractAuth {

    public function getVisitDriverTextAttribute($value);
    public function getVisitServiceTextAttribute($value);
    public function getVisitDriverRefreshAttribute();
    public function getVisitServiceRefreshAttribute();
    
}