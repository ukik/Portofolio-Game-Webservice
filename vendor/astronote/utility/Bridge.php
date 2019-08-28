<?php

class Bridge
{
	private $message;

	private $container = [];

	public static function instance()
	{
		return new Bridge();
	}

	public function Timechecker (...$payload)
	{
		if(method){
			switch(requests()){
				case 'time':
					$this->container = timechecker($payload);
					break;
			}
		}
		return $this;		
	}

	# --------------------------------------------------------------------
	# Research Only
	# --------------------------------------------------------------------

	public function Message1($message)
	{
		$this->message .= $message;

        return $this;
	}

	public function Message2($message)
	{
		$this->message .= $message;

        return $this;
	}

	function GetMessage()
    {
        return $this->message;		
    }	

	function GetContainer()
    {
        return $this->container;		
    }	

	# --------------------------------------------------------------------
	# --------------------------------------------------------------------
}