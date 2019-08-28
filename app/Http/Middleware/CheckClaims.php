<?php

namespace App\Http\Middleware;

use Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckClaims
{

    public function handle($request, \Closure $next)
    {

        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }

        try {

            $user = JWTAuth::authenticate($token);
            $payload = JWTAuth::parseToken()->getPayload();
            if ($payload['claim'] == null) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            Session::flash('payload', $payload);
			Session::flash('token', $token);
			
            return $next($request);

        } catch (JWTException $e) {

            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(array('message' => 'token_expired'), $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(array('message' => 'token_invalid'), $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(array('message' => 'token_absent'), $e->getStatusCode());
        }
    }

    public function terminate($request, $response)
    {
        return "protocol clear";
    }

}
