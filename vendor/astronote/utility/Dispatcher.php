<?php

use Validator;

trait Dispatcher
{

    private $value;

    protected function Auth_Login()
    {
        $request = [decode_key(getter('request')) => base_auth_value(getter('request'))];

        $valid = Validator::make($request, [
            'access' => 'required|in:login',
        ]);

        if ($valid->fails()){
            return responses('error login');
        } 

        $this->value .= base_auth_value(getter('request'));
        return $this;
    }

    protected function Auth_Register()
    {
        $request = [decode_key(getter('request')) => base_auth_value(getter('request'))];

        $valid = Validator::make($request, [
            'access' => 'required|in:register',
        ]);

        if ($valid->fails()){
            return responses('error register');
        } 

        $this->value .= base_auth_value(getter('request'));
        return $this;
    }

    protected function Auth_Forget()
    {
        $request = [decode_key(getter('request')) => base_auth_value(getter('request'))];

        $valid = Validator::make($request, [
            'access' => 'required|in:forget',
        ]);

        if ($valid->fails()){
            return responses('error forget');
        } 

        $this->value .= base_auth_value(getter('request'));
        return $this;
    }    

    protected function Auth_Reset()
    {
        $request = [decode_key(getter('request')) => base_auth_value(getter('request'))];

        $valid = Validator::make($request, [
            'access' => 'required|in:reset',
        ]);

        if ($valid->fails()){
            return responses('error reset');
        } 

        $this->value .= base_auth_value(getter('request'));
        return $this;
    }    

    protected function Auth_Player()
    {
        $request = [decode_key(getter('request')) => base_auth_value(getter('request'))];

        $valid = Validator::make($request, [
            'access' => 'required|in:player',
        ]);

        if ($valid->fails()){
            return responses('error reset');
        } 

        $this->value .= base_auth_value(getter('request'));
        return $this;
    }    

    public function Auth()
    {
        $this->Auth_Forget();
        $this->Auth_Login();
        $this->Auth_Register();
        $this->Auth_Reset();
        $this->Auth_Player();
        return $this->value == null ? responses('failed access') : $this->value;
    }
}

