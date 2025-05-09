<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_detail_model extends CI_Model {

    protected $table = 'invoice_details';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Insert a new invoice detail record
     * 
     * @param array $data Invoice detail data
     * @return int Inserted ID
     */
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Get details by invoice ID
     * 
     * @param int $invoice_id Invoice ID
     * @return array Invoice details
     */
    public function get_by_invoice_id($invoice_id) {
        $this->db->where('invoice_id', $invoice_id);
        $query = $this->db->get($this->table);
        return $query->result();
    }
}