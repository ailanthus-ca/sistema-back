<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Middleware {

    private $key = 'qdlWpQDhJIE5LGGYzfDpWYZsuMnvBzBE';

    /**
     * Get header Authorization
     * */
    function getAuthorizationHeader() {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * get access token from header
     * */
    function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    function safeEncrypt($message) {
        $encode = base64_encode($message);
        $cipher = base64_encode($this->key . $encode);
        return $cipher;
    }

    function safeDecrypt($encrypted) {
        $decoded = base64_decode($encrypted);
        $ciphertext = mb_substr($decoded, strlen($this->key), null, '8bit');
        $decoded = base64_decode($ciphertext);
        return $decoded;
    }

    function unAutenticacted() {
        header("HTTP/1.0 401 Success");
        return array(
            'error' => 'NO AUTENTICADO'
        );
    }

}
