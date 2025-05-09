<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_client {
    
    protected $ci;
    protected $base_url;
    protected $timeout = 30;
    protected $api_key = '';
    
    public function __construct($config = array()) {
        $this->ci =& get_instance();
        
        // Load configuration if provided
        if (!empty($config)) {
            $this->initialize($config);
        }
    }
    
    public function initialize($config = array()) {
        foreach ($config as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }
        
        return $this;
    }
    
    public function get($endpoint, $params = array(), $headers = array()) {
        return $this->request('GET', $endpoint, $params, $headers);
    }
    
    public function post($endpoint, $data = array(), $headers = array()) {
        return $this->request('POST', $endpoint, $data, $headers);
    }
    
    public function put($endpoint, $data = array(), $headers = array()) {
        return $this->request('PUT', $endpoint, $data, $headers);
    }
    
    public function delete($endpoint, $params = array(), $headers = array()) {
        return $this->request('DELETE', $endpoint, $params, $headers);
    }
    
    protected function request($method, $endpoint, $data = array(), $headers = array()) {
        // Initialize cURL
        $ch = curl_init();
        
        // Set URL
        $url = $this->base_url . $endpoint;
        
        // Set default headers
        $default_headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        
        // Add API key to headers if set
        if (!empty($this->api_key)) {
            $default_headers[] = 'Authorization: Bearer ' . $this->api_key;
        }
        
        // Merge with custom headers
        $headers = array_merge($default_headers, $headers);
        
        // Set cURL options based on method
        switch ($method) {
            case 'GET':
                if (!empty($data)) {
                    $url .= '?' . http_build_query($data);
                }
                break;
                
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
                
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
                
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($data)) {
                    $url .= '?' . http_build_query($data);
                }
                break;
        }
        
        // Set common cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // Execute request
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        // Close connection
        curl_close($ch);
        
        // Check for errors
        if (!empty($error)) {
            return array(
                'success' => false,
                'error' => $error,
                'status_code' => $status_code
            );
        }
        
        // Parse JSON response
        $result = json_decode($response, true);
        
        // Check for JSON parsing errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            return array(
                'success' => false,
                'error' => 'Invalid JSON response: ' . json_last_error_msg(),
                'status_code' => $status_code,
                'raw_response' => $response
            );
        }
        
        return array(
            'success' => ($status_code >= 200 && $status_code < 300),
            'data' => $result,
            'status_code' => $status_code
        );
    }
}