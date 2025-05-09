<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
    
    private $api_url = 'https://api.example.com/upload'; // Replace with your API endpoint
    private $api_key = 'your_api_key'; // Replace with your API key if needed
    
    public function __construct() {
        parent::__construct();
        $this->load->library('curl');
    }
    
    public function send_base64_image($base64_string) {
        // Validate base64 string
        if (strpos($base64_string, 'data:image/') !== 0) {
            return ['success' => false, 'message' => 'Invalid image format'];
        }
        
        // Prepare data for API
        $post_data = [
            'image' => $base64_string,
            'api_key' => $this->api_key,
            // Add any other required parameters for your API
        ];
        
        // Set cURL options
        $options = [
            CURLOPT_URL => $this->api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($post_data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 30
        ];
        
        // Initialize cURL
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        
        // Execute the request
        $response = curl_exec($curl);
        $error = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // Close cURL
        curl_close($curl);
        
        // Handle response
        if ($error) {
            log_message('error', 'API cURL Error: ' . $error);
            return ['success' => false, 'message' => 'Connection error: ' . $error];
        }
        
        // Decode response
        $decoded_response = json_decode($response, true);
        
        // Check if response is valid JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'API Response Error: Invalid JSON response');
            return [
                'success' => false, 
                'message' => 'Invalid response from API',
                'http_code' => $http_code
            ];
        }
        
        // Log successful response
        log_message('info', 'API Response: ' . $response);
        
        // Add HTTP code to response
        $decoded_response['http_code'] = $http_code;
        
        return $decoded_response;
    }
}

?>