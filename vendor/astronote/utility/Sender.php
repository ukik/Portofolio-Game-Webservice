<?php

class Sender
{

    private $ch;

    private $response = false;

    public function __construct($url, $options = null)
    {

        $this->ch = curl_init($url);

        //building headers for the request

        $headers = array(
            'Authorization: key=' . 'AIzaSyBExUkJGJL8QNX8Af1d2Dgo-0MsYFK5wvI',
            'Content-Type: application/json',
        );

        //Setting the curl url
        curl_setopt($this->ch, CURLOPT_URL, $url);

        //setting the method as post
        curl_setopt($this->ch, CURLOPT_POST, true);

        //adding headers
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        //disabling ssl support
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

        //adding the fields in json format
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($options));

        $result = curl_exec($this->ch);

        if ($result === false) {
            die('Curl failed: ' . curl_error($this->ch));
        }

        //Now close the connection
        curl_close($this->ch);

    }

    public function getResponse()
    {
        if ($this->response) {
            return $this->response;
        }

        $response   = curl_exec($this->ch);
        $error      = curl_error($this->ch);
        $errno      = curl_errno($this->ch);

        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }

        return $this->response = $response;

    }

    public function __toString()
    {
        return $this->getResponse();
    }
}
