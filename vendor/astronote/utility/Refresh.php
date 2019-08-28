<?php

use App\User;
use App\Model\User\GetUser;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Exception\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\PayloadFactory;

use Hash;

class Refresh
{

    protected static $complete;
    protected static $hash;
    protected static $user;

	public static function Instance()
	{
		return new Refresh();
    }

    public static function Clean($request)
    {
		$passport   = $request->header('Authorization');		
        $passport   = str_replace('Bearer ', '', $passport);

        self::$hash = Hash::make(rand(0, 99999));

        self::$user = User::where('token', $passport)->first();

        if(!self::$user){
            return 'false';
        }

        self::RefreshJWT();

        self::RefreshPassport();

        Setter('security', self::$complete);

        return 'true';
    }
    
    protected function RefreshJWT()
    {
        $request = self::$user;

        $credentials = ['claim' => [
            'scope' => $request->scope,
            'key'   => self::$hash            
        ]];

        $api = JWTAuth::fromUser($request, $credentials);

        User::updateOrCreate(
            ['email' => $request->email],
            [
                'api'               => $request->api, 
                'remember_token'    => '',
                'claim'             => self::$hash,
                'protocol'          => Hash::make(rand(0, 99999))                
            ]
		);
    }  

    # Renewal Old Passport
    protected function RefreshPassport()
    {   
        $request = self::$user;
        $token   = $request->createToken($request, [$request->scope])->accessToken;		

		User::updateOrCreate(
			['email' => $request->email],
			[
                'token' => $token,
			]
		);
        
        self::$complete = GetUser::where('email', $request->email)->first();
    }

}