<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
    
    private $api_client;
    
    public function __construct() {
        parent::__construct();
        
        // Load API client library
        $this->load->library('api_client', array(
            'base_url' => 'http://13.229.79.176/api/', // Replace with your API base URL
            'api_key' => 'your_api_key', // Replace with your API key
            'timeout' => 30
        ));
        
        $this->api_client = $this->api_client;
    }
    
    public function get_users() {
        $response = $this->api_client->get('approve/list');
        
        if ($response['responseCode']=="00") {
            return $response['data'];
        } else {
            log_message('error', 'API Error: ' . $response['error'] ?? 'Unknown error');
            return array();
        }
    }
    
    public function get_user($id) {
        $response = $this->api_client->get('users/' . $id);
        
        if ($response['success']) {
            return $response['data'];
        } else {
            log_message('error', 'API Error: ' . $response['error'] ?? 'Unknown error');
            return null;
        }
    }
    
    public function create_user($user_data) {
        $response = $this->api_client->post('users', $user_data);
        
        if ($response['success']) {
            return $response['data'];
        } else {
            log_message('error', 'API Error: ' . $response['error'] ?? 'Unknown error');
            return false;
        }
    }
    
    public function update_user($id, $user_data) {
        $response = $this->api_client->put('users/' . $id, $user_data);
        
        if ($response['success']) {
            return $response['data'];
        } else {
            log_message('error', 'API Error: ' . $response['error'] ?? 'Unknown error');
            return false;
        }
    }
    
    public function delete_user($id) {
        $response = $this->api_client->delete('users/' . $id);
        
        if ($response['success']) {
            return true;
        } else {
            log_message('error', 'API Error: ' . $response['error'] ?? 'Unknown error');
            return false;
        }
    }
    
    // Add more methods for other API endpoints as needed
}