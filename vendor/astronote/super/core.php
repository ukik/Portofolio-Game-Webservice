<?php

    function Setter($key = null, $val = null)
    {
        return Session::flash($key, $val);
    }

    function Getter($key = null)
    {
        return Session::get($key);
    }

	function Method ()
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' ? 1 : 0;
	}

    function library_keyword($value)
    {
        return base64_decode($value);
    }

    function Decode_Param($value)
    {
        return base64_decode(gzinflate($value));
    }

    function Decode_Key($value, $index = 0)
    {
        return base64_decode(gzinflate(array_keys($value)[$index]));
    }

    function Decode_Value($value, $index = 0)
    {
        return base64_decode(gzinflate(array_values($value)[$index]));
    }

    function Base_Paginate_Value($value, $index = 0)
    {
        return base64_decode(array_values($value)[$index]);        
    }

    function Base_Auth_Value($value)
    {
        return base64_decode(gzinflate(base_paginate_value($value)));        
    }

    function Message($val)
    {
        switch ($val) {
            case 'url':
                return \Config::get('app.firebase_url');        
                break;
            case 'key':
                return \Config::get('app.firebase_key');     
                break;
        }
    }

    function Email()
    {
        return \Config::get('app.email_sender'); 
    }

    function Attach($key, $val)
    {
		return \Cache::add($key, $val, 1);	
    }

    function History($key, $val)
    {
        return \Cache::forever($key, $val);
    }

    function Detach($key)
    {
        return \Cache::pull($key);	
    }

    function Banish($key)
    {
        return \Cache::forget($key);        
    }

	function Responses($source = '', $status = 200)
	{
        //the secret at middleware of empty string to null 0_0        
		return response()->json($source, $status);
			// ->header(getter('obfuscator-title'), getter('obfuscator-value'));
    }   
    
	function Handlers($source = '', $status = 200, ...$handles)
	{
        //the secret at middleware of empty string to null 0_0        
		return response()->json($source, $status);
			// ->header($handles[0], $handles[1]);
	}       

    function Clean(Illuminate\Http\Request $request)
    {
        return Refresh::clean($request);        
    }

    function User()
    {
        $code_user = getter('user')->code_user;
        return \App\Model\User\GetUser::whereCodeUser($code_user)
            ->with('summary')
            ->with('wallet')
            ->first();
    }

    // FilterAvailablitiyUnion.php
    # only used to union table
    /**
     * $value (array) / ['no' => 1]
     * $perPage (int)
     * 
     * return paginator($included_library->get(), 50);
     */
    function Paginator($value, $perPage)
    {
        //Define how many items we want to be visible in each page
        // $perPage = 5;

        //Create a new Laravel collection from the array data
        $collection = new Illuminate\Database\Eloquent\Collection($value);

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection
            ->slice($currentPage * $perPage, $perPage)
            ->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults = new Illuminate\Pagination\LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

        return $paginatedSearchResults;
    }

?>