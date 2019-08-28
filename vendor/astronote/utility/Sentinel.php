<?php

use App\Model\Library\GetTools;
use App\Model\Library\GetVehicle;
use App\Model\Library\GetSetting;

use App\Model\Mutation\Record\PostTools;
use App\Model\Mutation\Record\PostVehicle;

use App\Model\User\PostWallet;
use App\Model\User\PostSummary;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class Sentinel
{

    protected static $complete;
    protected static $hash;
    protected static $user;

    public static function Instance()
    {
        return new Sentinel();
    }

    public static function Register(Illuminate\Http\Request $request)
    {

        $client = $request->only('name', 'password', 'address', 'scope', 'email', 'phone');

        $v = Validator::make($client, 
            [
                'name'      => 'required|string|max:255',
                'password'  => 'required|string|min:6',
                'scope'     => 'required|string|in:player,admin',
                'email'     => 'required|string|email|max:255|unique:user',
                // 'address'   => 'required|string',
                // 'phone'     => 'required|numeric|digits_between:8,20|unique:user,phone,NULL,id,email,' . $request->email . ',scope,' . $request->scope,
            ]
        );

        if ($v->fails()) {
            setter('validation', 'failed');
            return setter('status', $v->errors()->all());
        }

        $faker = Faker\Factory::create();
        $uuid = $faker->uuid;

        self::$hash = Hash::make(rand(0, 99999));

        self::RegisterUser($request, $uuid);

        // self::RegisterJWT($request);

        // self::NewPassport($request);

        setter('security', self::$complete);
        setter('status', 'login');

        // event(new RegisterEvent($target = $request->email));

        try {
            Mail::send('emails.register', ['user' => self::$complete], function($message) use ($client)
            {
                $message
                    ->from(email())
                    ->to($client['email'])
                    ->subject("Game Pesanbungkus - Admin Baru !!!");
            });        
        } catch(Exception $e){

        }

        return self::$complete;
    }

    public static function Player(Request $request)
    {
        $client = $request->only('name', 'password', 'address', 'scope', 'email', 'phone');

        $v = Validator::make($client, 
            [
                'name'      => 'required|string|max:255',
                'password'  => 'required|string|min:6',
                'scope'     => 'required|string|in:player,admin',
                'email'     => 'required|string|email|max:255|unique:user',
                //'address'   => 'required|string',
                //'phone'     => 'required|numeric|digits_between:8,20|unique:user,phone,NULL,id,email,' . $request->email . ',scope,' . $request->scope,
            ]
        );
            
        if ($v->fails()) {
            setter('validation', 'failed');
            return setter('status', $v->errors()->all());
        }

        $faker = Faker\Factory::create();
        $uuid = $faker->uuid;

        self::$hash = Hash::make(rand(0, 99999));

        self::RegisterUser($request, $uuid);

        self::RegisterGameAttribute($uuid, $faker);

        self::RegisterJWT($request);

        self::NewPassport($request);

        setter('security', self::$complete);
        setter('status', 'login');

        // event(new RegisterEvent($target = $request->email));

        try {
            Mail::send('emails.player', ['user' => self::$complete], function($message) use ($client)
            {
                $message
                    ->from(email())
                    ->to($client['email'])
                    ->subject("Game Pesanbungkus - Pemain Baru !!!");
            });
        } catch (Exception $e) {

        }
        
        return self::$complete;
    }

    # Forget Handler
    public static function Forget(Request $request)
    {
        $client = $request->only('email');

        if(empty($request->email)){
            setter('status', 'failed');
            return;
        }

        $v = Validator::make($client, [
            'email' => 'required|string|email|max:255|unique:user',
        ]);

        if (!$v->fails()) { # reverse condition
            return responses(['status' => 'invalid']);
        }

        self::$hash = Hash::make(rand(0, 99999));

        $user = User::where('email', $client)->orWhere('phone', $client);

        if(!$user->first()){
            setter('status', 'failed');
            return;            
        }

        $update = $user->update(['remember_token' => bcrypt(rand(0, 99999)) . '.' . Hash::make(rand(0, 99999))]);

        self::ForgetJWT($user->first());

        self::RenewalPassport($user->first());
        
        // event(new ForgetEvent($target = $request->email));

        try {
            Mail::send('emails.register', ['user' => $user->first()], function($message) use ($client)
            {
                $message
                    ->from(email())
                    ->to($client['email'])
                    ->subject("Game Pesanbungkus - Lupa Password !!!");
            });
        } catch (Exception $e) {

        }

        setter('security', self::$complete);
        setter('status', 'success');

        return;
        //return self::$complete; //'success';
    }

    # Reset Handler
    public static function Reset(Request $request)
    {
        self::$hash = Hash::make(rand(0, 99999));

        $user = User::where('email', request()->user()->email);
        $user->update(['remember_token' => null]);

        self::ResetJWT($user->first());

        self::RenewalPassport($user->first());

        event(new ResetEvent());

        return self::$complete;
    }

    # Login Handler
    public static function Login(Request $request)
    {
        $client = $request->only('email', 'password', 'scope');

        $v = validator($client, [
            'email'     => 'required|string|email|max:255',
            'password'  => 'required|string|min:6',
            'scope'     => 'required|string',
        ]);

        if ($v->fails()) {
            return response()->json($v->errors()->all(), 400);
        }

        self::$hash = Hash::make(rand(0, 99999));

        self::LoginJWT($request);

        if (self::$user == null) {
            return responses('terminated ' . Hash::make(rand(0, 99999)));
        }

        self::NewPassport($request);

        setter('security', self::$complete);
        setter('status', 'login');

        // event(new LoginEvent($target = $request->email));

        return self::$complete;
    }

    # Create new User
    protected function RegisterUser(Request $request, $uuid)
    {
        // $faker = Faker\Factory::create();
        // $uuid = $faker->uuid;

        $client = $request->all();

        $forms = [
            'code_user'     => $uuid,
            'name'          => $client['name'],
            'email'         => $client['email'],
            'address'       => $client['address'],
            'phone'         => $client['phone'],
            'password'      => bcrypt($client['password']),
            'plain'         => $client['password'], // clien name is password, but server & database as plain
            'scope'         => $client['scope'],
            'claim'         => self::$hash,
            'protocol'      => Hash::make(rand(0, 99999)),
            'verification'  => $client['scope'] == 'player' ? NULL : bcrypt(Hash::make(rand(0, 99999))),
        ];

        User::create($forms);

        self::$complete = User::where('email', $client['email'])->with('wallet')->with('summary')->first();
    }

    # Create new Game Mission & Bonus
    protected function RegisterGameAttribute($uuid, $faker)
    {
 
        $setting = GetSetting::whereAlias('first_deposit')->value('value');

        # new wallet
        PostWallet::updateOrCreate(
            [
                'code_user'     => $uuid,
            ],
            [
                'code_user'     => $uuid,
                'code_wallet'   => $faker->uuid,
                'activity'      => 0,
                'cash_in'       => $setting,
                'cash_out'      => 0,
                'coin_in'       => $setting,
                'coin_out'      => 0,
                'score_in'      => 0,
                'tools_vehicle' => 7,                
            ]
        );

        # new summary        
        PostSummary::updateOrCreate(
            [
                'code_user'     => $uuid,
            ],
            [
                'code_user'     => $uuid,
                'code_summary'  => $faker->uuid,
                'activity'      => 0,
                'cash_in'       => 0,
                'cash_out'      => 0,
                'coin_in'       => 0,
                'coin_out'      => 0,
                'score_in'      => 0,
                'tools_vehicle' => 7,                
            ]
        );        

        # new tools
        // washer,service,fashion        
        $tools = GetTools::where('level', "1")
            ->whereIn('package', ['service', 'washer', 'fashion'])
            ->get();
   
        $vehicle = GetVehicle::where('level', "1")
            ->whereIn('package', ['motorcycle', 'motorbox', 'mobil', 'pickup'])
            ->get();

        foreach ($tools as $key => $value) {
            PostTools::updateOrCreate(
                [
                    'code_user'     => $uuid,
                    'level'         => $value->level,
                    'package'       => $value->package,
                ],
                [
                    'code_user'     => $uuid,
                    'code_this'     => $faker->uuid,
                    'code_tools'    => $value->code_tools,
                    'package'       => $value->package,
                    'title'         => $value->title,
                    'level'         => $value->level,
                    'name'          => $value->name,
                    'description'   => $value->description,
                    'cash'          => $value->cash,
                    'coin'          => $value->coin,
                    'discount'      => $value->discount,
                    'slot'          => $value->slot,
                ]
            );            
        }

        foreach ($vehicle as $key => $value) {
            PostVehicle::updateOrCreate(
                [
                    'code_user'     => $uuid,
                    'level'         => $value->level,
                    'package'       => $value->package,
                ],
                [
                    'code_user'     => $uuid,
                    'code_this'     => $faker->uuid,
                    'code_vehicle'  => $value->code_vehicle,
                    'package'       => $value->package,
                    'title'         => $value->title,
                    'level'         => $value->level,
                    'name'          => $value->name,
                    'description'   => $value->description,
                    'cash'          => $value->cash,
                    'coin'          => $value->coin,
                    'discount'      => $value->discount,
                    'health'        => $value->health,
                    'fuel'          => $value->fuel,
                    'slot'          => $value->slot,
                ]
            );       
        }        

    }

    # Create new JWT
    protected function RegisterJWT(Request $request)
    {
        $credentials = ['claim' => [
            'scope' => $request->scope,
            'key'   => self::$hash,
        ]];

        $api = JWTAuth::attempt($request->only('email', 'password'), $credentials);

        User::updateOrCreate(
            ['email' => $request->email],
            [
                'api' => $api,
            ]
        );
    }

    # Renewal old JWT
    protected function ForgetJWT($request)
    {
        $credentials = ['claim' => [
            'scope' => $request['scope'],
            'key'   => self::$hash,
        ]];

        $api = JWTAuth::fromUser($request, $credentials);

        User::updateOrCreate(
            ['email' => $request['email']],
            [
                'api'       => $api,
                'claim'     => self::$hash,
                'protocol'  => Hash::make(rand(0, 99999)),
            ]
        );
    }

    # Renewal old JWT
    protected function ResetJWT($request)
    {
        $credentials = ['claim' => [
            'scope' => $request['scope'],
            'key'   => self::$hash,
        ]];

        $api = JWTAuth::fromUser($request, $credentials);

        User::updateOrCreate(
            ['email' => $request['email']],
            [
                'api'       => $api,
                'claim'     => self::$hash,
                'protocol'  => Hash::make(rand(0, 99999)),
            ]
        );
    }

    # Renewal old JWT
    public function LoginJWT(Request $request)
    {
        $client = $request->only('email', 'password');
        
        $data = User::where('email', $client['email'])
            ->where('plain', $client['password'])
            ->where('verification', '=', null)
            ->first();

        if (!$data) {
            return self::$user = $data;
        }

        $credentials = ['claim' => [
            'scope' => $data['scope'],
            'key' => self::$hash,
        ]];

        $api = JWTAuth::fromUser($data, $credentials);

        User::updateOrCreate(
            ['email' => $data['email']],
            [
                'api'       => $api,
                'claim'     => self::$hash,
                'protocol'  => Hash::make(rand(0, 99999)),
            ]
        );

        self::$user = $data;
    }

    # Create Fresh Passport
    protected function NewPassport(Request $request)
    {
        $client = \Laravel\Passport\Client::where('password_client', 1)->first();

        if ($request->all() == 'undefined' || $request->all() == null) {
            $data = $request->json()->all();
        } else {
            $data = $request->all();
        }

        // Proxy Version
        $forms = [
            'grant_type'        => 'password',
            'client_id'         => $client->id,
            'client_secret'     => $client->secret,
            'username'          => $data['email'],
            'password'          => $data['password'],
            'scope'             => $data['scope'], // dari client
        ];

        $request->request->add($forms);

        // produce access_token & refresh_token
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $json = \Route::dispatch($proxy);

        $jstring = (string) $json;

        function removeEverythingBefore($in, $before)
        {
            $pos = strpos($in, $before);
            return $pos !== false
            ? substr($in, $pos + strlen($before), strlen($in))
            : "";
        }

        function AccessToken($string)
        {
            $one = strstr($string, 'access_token'); // gets text before /
            $two = strstr($one, 'refresh_token', true); // gets text after /
            $three = removeEverythingBefore($two, 'access_token":"');
            return $four = str_replace('","', '', $three);
        }

        function RefreshToken($string)
        {
            $one = strstr($string, 'refresh_token'); // gets text before /
            $two = removeEverythingBefore($one, 'refresh_token":"');
            return $three = str_replace('"}', '', $two);
        }

        $access_token = AccessToken($jstring);
        $user = User::class;
        
        $_user = $user::where('email', $data['email'])
            ->where('plain', $data['password'])
            ->where('verification', '=', null);
            // scope:player -> maka verification = null
            
        // jika player maka tidak perlu verification
        // jika admin perlu verification

        if (!$_user->first()) {
            return self::$user = $_user->first();
        }

        // Direct Version
        // if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
        //     $user = Auth::user(); 
        //     $success['token'] =  $user->createToken('login_token', [$data['scope']])->accessToken; 
        // } 
        if($access_token == '' || $access_token || $access_token == null){
            $access_token = $_user->first()->createToken('login_token', [ $data['scope'] ])->accessToken;
        }

        $user::updateOrCreate(
            ['email' => $data['email']],
            [
                'token' => $access_token,
            ]
        );

        self::$complete = $_user->with('wallet')->with('summary')->first();
    }

    # Renewal Old Passport
    protected function RenewalPassport($request)
    {
        $token = $request->createToken($request, [$request->scope])->accessToken;

        User::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => $token,
            ]
        );

        self::$complete = User::where('email', $request->email)->with('wallet')->with('summary')->first();
    }
}
