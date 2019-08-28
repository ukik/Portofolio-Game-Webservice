<?php

use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Guardian
{

    public function handle($request, \Closure $next)
    {

        if (Method() == 0 && $_GET['access'] == 'reset' && isset($_GET['token'])) {
            if (!$token = JWTAuth::getToken()) {
                return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
            }

            $token = JWTAuth::getToken();

            try {

                $auth = JWTAuth::authenticate($token);

                $payload = JWTAuth::parseToken()->getPayload()['claim'];

                $user = User::where('scope', $payload['scope'])
                    ->where('claim', $payload['key'])
                    ->first();

                # System will check if token still valid but remember_token has null
                if (!$user['remember_token'] && $user != null) {
                    return responses(['info' => 'visited', 'data' => $user]);
                }

                # System will check if remember has value and remember_token has value
                if ($_GET['remember'] != $user['remember_token']) {
                    return response()->json(['error' => 'invalid_remember'], 401);
                }

                # System will check if token invalid
                if ($user == null) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }

                $request = Request::create('api/user/user?token' . $user['protocol'], 'POST', ["api" => $token]);
                $request->headers->set('Authorization', 'Bearer ' . $user['token']);
                $request->headers->set('Proxy-Authorization', 'Bearer ' . $user['claim']);

                $response = $next($request);

                setter('passport', $user['token']);
                setter('user', $user);

                $response = Route::dispatch($request);

                return $response;

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

        } else {

            return $next($request);
        }

    }
}
