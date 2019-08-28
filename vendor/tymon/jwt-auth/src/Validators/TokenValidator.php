<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tymon\JWTAuth\Validators;

use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Session;

use App\User;

class TokenValidator extends AbstractValidator
{
    /**
     * Check the structure of the token.
     *
     * @param string  $value
     * @return void
     */
    public function check($value)
    {
        #$api = $request->header('Proxy-Authorization');		
        #$api = str_replace('Bearer ', '', $api);     

        #echo gettype($value);

        #dd(Session::get('callback')['email']);
        // $user = User::where('email', Session::get('callback')['email'])->value('api');

        #echo gettype($user);

        $this->validateStructure($value);
    }

    /**
     * @param  string  $token
     * @throws \Tymon\JWTAuth\Exceptions\TokenInvalidException
     * @return bool
     */
    protected function validateStructure($token)
    {
        if (count(explode('.', $token)) !== 3) {
            throw new TokenInvalidException('Wrong number of segments');
        }

        return true;
    }
}
